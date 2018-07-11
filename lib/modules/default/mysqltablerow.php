<?php 
	class MysqlTableRow {

		static function __table_name() { return ''; }
		static function __primary_key() { return 'id'; }
		static function __connection_name() { return 'master'; }
		static function __table_prefix() { return Config::self()->data['mysql'][static::__connection_name()]['prefix']; }
		static function __buildWhere($arg = [], $separator = ' AND ') {

			// ['arg' => [ ['expired', '<', 1000], ['expired', '>', [100, 200]], 'date > (now() - interval 1 day)', 'name' => 'alex', 'city' => [1,2], 'or' => ['active' => ['Y', 'N'], 'deleted' => 1] ] ]
			// where name in (alex)
			//		 and city in (1,2)
			//		 and (active in (Y, N) or deleted in (1))
			//		 and date > (now() - interval 1 day)

			$operators	= [
				'='			=> 'in',
				'in'		=> 'in',
				'!'			=> 'not in',
				'<>'		=> 'not in',
				'not in'	=> 'not in',
				'</>'		=> 'between',
				'between'	=> 'between',
				'!</>'		=> 'not between',
				'not between'=> 'not between',
				'null'		=> 'is null',
				'!null'		=> 'is not null',
				'~'			=> 'like',
				'!~'		=> 'not like',
				'<'			=> '<',
				'>'			=> '>',
				'>='		=> '>=',
				'<='		=> '<=',
			];

			$vals = [];
			$expressions = [];

			if(!empty($arg)) {
				// ['filter' => [ ['expired', '<', 1000], ['expired', '>', [100, 200]], 'date > (now() - interval 1 day)', 'name' => 'alex', 'city' => [1,2], 'or' => ['active' => ['Y', 'N'], 'deleted' => 1] ] ]
				if(is_array($arg)) foreach ($arg as $k => $v) {
					// ['filter' => [ ['expired', '<', 1000], ['expired', '>', [100, 200]], 'date > (now() - interval 1 day)' ]
					if(is_int($k)) {
						if(is_array($v)) {
							// ['filter' => [ ['url', 'in', ''], ['expired', '</>', [100, 200]], ]
							if(is_array($v[2])) {
								$values = (count($v[2])?$v[2]:['']);
							} else {
								$values = [$v[2]];
							}

							$expressions[] = '`'.$v[0].'` '.$operators[$v[1]].' (?'.str_repeat(in_array($v[1], ['</>', '</>', 'between', 'not between'])?' AND ':',?', count($values) - 1).')';
							$vals = array_merge($vals, $values);

						} else if(!empty($v)) {
							// ['filter' => [ 'date > (now() - interval 1 day)' ]
							$expressions[] = $v;
						}
					} else {
						// ['filter' => [ 'name' => 'alex', 'city' => [1,2], 'or' => ['active' => ['Y', 'N'], 'deleted' => 1] ] ]
						if($k == 'or') {
							// ['filter' => [ 'or' => [ 'date > now()', [id, '</>', [100,200]], 'deleted' => 1, 'active' => ['Y', 'N'], ] ] ]
							list($expr, $values) = static::__buildWhere($v, ' OR ');
							if(!empty($expr)) {
								$expressions[] = '('.$expr.')';
								$vals = array_merge($vals, $values);
							}
						} else {
							// ['filter' => [ 'url' => '', 'city' => [], 'city' => [0], 'city' => [1,2], ]
							$oper = 'in';
							if(is_array($v)) {
								$values = (count($v)?$v:['']);
							} else {
								$values = [$v];
							}

							$expressions[] = '`'.$k.'` '.$operators[$oper].' (?'.str_repeat(',?', count($values) - 1).')';
							$vals = array_merge($vals, $values);
						}
					}
				} else if(!empty($arg)) {
					// ['filter' => 'date > (now() - interval 1 day)' ]
					$expressions[] = $arg;
				}
			}

			$expressions = implode($separator, $expressions);

			return [$expressions, $vals];
		}
		static function __buildQuery($arg = []) {

			$vals = [];
			$cols = ['*'];
			$filter = '';
			$groupby = [];
			$orderby = [];
			$having = '';
			$start = 0;
			$limit = 0;

			if(!empty($arg['cols'])) $cols = $arg['cols'];
			if(!empty($arg['filter'])) list($filter, $vals) = static::__buildWhere($arg['filter']);
			if(!empty($arg['groupby'])) $groupby = (is_array($arg['groupby'])?$arg['groupby']:[$arg['groupby']]);
			if(!empty($arg['having'])) {
				list($having, $having_vals) = static::__buildWhere($arg['having']);
				$vals = array_merge($vals, $having_vals);
			}
			if(!empty($arg['orderby'])) $orderby = (is_array($arg['orderby'])?$arg['orderby']:[$arg['orderby']]);
			if(!empty($arg['start'])) $start = (int)$arg['start'];
			if(!empty($arg['limit'])) $limit = (int)$arg['limit'];

			if(!is_array($cols)) $cols = [$cols];

			return ['SELECT '.implode(', ', $cols)
				.' FROM `'.static::__table_prefix().static::__table_name().'`'
				.(!empty($filter)?PHP_EOL.'WHERE '.$filter:'')
				.(!empty($groupby)?PHP_EOL.'GROUP BY '.implode(', ', $groupby):'')
				.(!empty($having)?PHP_EOL.'HAVING '.$having:'')
				.(!empty($orderby)?PHP_EOL.'ORDER BY '.implode(', ', $orderby):'')
				// binding start and limit as values make them 'strings'
				// so they must be numbers
				.($start || $limit?PHP_EOL.'LIMIT '.$start.', '.$limit:'')
			, $vals];
		}

		static function find($arg = []) {
			list($query, $vals) = static::__buildQuery($arg);
			return Mysql::sql(static::__connection_name(), $query, $vals, static::class);
		}

		static function findOne($arg = []) {
			$res = static::find(array_merge($arg, ['limit' => 1]));
			$class = static::class;

			return (!empty($res[0])?$res[0]:new $class());
		}
		function save($arg = []) {

			EventManager::call('before.save', $this);

			$cols = [];
			$cols_onduplicate = [];
			$vals = [];
			$pk = static::__primary_key();
			$pk_id = $this->$pk;

			if(empty($pk_id)) {
				foreach ($this as $k => $v) {
					$cols[] = '`'.$k.'` = ?';
					$cols_onduplicate[] = '`'.$k.'` = values(`'.$k.'`)';
					$vals[] = $v;
				}
				$query = 'insert ignore into '
					.static::__table_prefix().static::__table_name()
					.' set '.implode($cols, ', ')
					.' on duplicate key update '.implode($cols_onduplicate, ', ');
			} else {
				foreach ($this as $k => $v) if($k != $pk) {
					$cols[] = '`'.$k.'` = ?';
					$vals[] = $v;
				}
				$vals[] = $pk_id;
				$query = 'update '.static::__table_prefix().static::__table_name()
					.' set '.implode($cols, ', ')
					.' where `'.$pk.'` = ?';
			}

			$res = Mysql::sql(static::__connection_name(), $query, $vals);

			if(empty($pk_id)) {
				$this->$pk = Mysql::sql(static::__connection_name(), 'select last_insert_id()');
			}

			EventManager::call('after.save', $this);
		}

		function remove($arg = []) {

			EventManager::call('before.remove', $this);

			$pk = static::__primary_key();
			$pk_id = $this->$pk;

			if(!empty($pk_id)) {

				$query = 'delete from '.static::__table_prefix().static::__table_name()
					.' where `'.$pk.'` = ?';

				$res = Mysql::sql(static::__connection_name(), $query, [$pk_id]);
			}

			EventManager::call('after.remove', $this);
		}

		function __construct($arg = []) {

			foreach ($arg as $k => $v) {
				$this->$k = $v;
			}
		}

		function __get($name) {
			return (method_exists($this, $method = 'get'.$name)?$this->$method():'');
		}

		function __set($name, $value) {
			return (method_exists($this, $method = 'set'.$name)?$this->$method($value):$this->$name = $value);
		}
	}
?>