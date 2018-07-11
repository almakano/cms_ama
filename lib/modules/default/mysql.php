<?php 
	class Mysql extends Singleton {
		static $connections = [];
		static $queries = [];

		static function sql($connname = 'master', $query = '', $vals = [], $classname = '') {

			if(empty(static::$connections[$connname])) {

				$c = array_merge([
					'host' => '127.0.0.1',
					'port' => 3306,
					'dbname' => '',
					'user' => '',
					'pass' => '',
					'prefix' => '',
					'charset' => 'utf8',
				], Config::self()->data['mysql'][$connname]);

				static::$connections[$connname] = new \PDO('mysql:'
					.'host='.$c['host'].';'
					.'port='.$c['port'].';'
					.'dbname='.$c['dbname'].';'
					.'charset='.$c['charset']
				, $c['user'], $c['pass'], [
					// PDO::ATTR_EMULATE_PREPARES => true,
				]);
			}

			$res = false;

			if(!empty(static::$connections[$connname])) {

				$speed = microtime(true);
				$prepared = static::$connections[$connname]->prepare($query);

				$error = static::$connections[$connname]->errorInfo();
				if($prepared && empty($error[2])) {
					$prepared->execute($vals);
				} else {
					$speed = 0;
					Debug::add('<span style="color: red">Mysql: '.$error[2].'</span>');
					return $res;
				}
				$speed = microtime(true) - $speed;

				static::$queries[] = ['query' => $query, 'vars' => $vals, 'speed' => number_format($speed, 5)];

				if(!$prepared) {
					$error = static::$connections[$connname]->errorInfo();
					Debug::add('Mysql error: '.$error[2]);
				} else {
					if(!empty($classname)) {
						$res = $prepared->fetchAll(\PDO::FETCH_CLASS, $classname);
					} else {
						$res = $prepared->fetchAll(\PDO::FETCH_ASSOC);
					}
				}
			}
			return $res;
		}
	}
?>