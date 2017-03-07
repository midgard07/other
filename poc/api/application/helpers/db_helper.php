<?php
	/* Kumpulan function PHP yang bisa digunakan dalam development
	 * versi 1.0
	 * Oleh : Mendi Wijaya
	 * 
	 * function yang ada :
	 * - insert
	 * - update
	 * - delete
	 * - select
	 * - selectJoin
	 * - generateCode
	 */

	/* insert query, fungsi ini untuk menghasilkan query insert
	 * parameter 
	 * @table : string
	 * @data : array
	 * 
	 * return : string
	 * 
	 * Contoh hasil :
	 * INSERT INTO tbl_a(a,b) VALUES('value_a','value_b');
	 * 
	 * Contoh penggunaan :
	 
		 $data = array(
		 	'nim' => '1000',
		 	'nama' => 'acong' 	
		 );
		 
		 echo insert('tbl_karyawan', $data);
	 */
	function insert($table = '', $data = array())
	{
		$query = '';
		if(is_array($data)) {
			$total = count($data) - 1; $i = 0;
			$column = ''; $value = '';
			
			foreach($data as $key => $val) {
				$column .= $key; $value .= "'" . $val . "'";
				
				if($i < $total) { $column .= ','; $value .= ','; }
				++$i;
			}
			
			$query = 'INSERT INTO ' . $table . '('  . $column . ') VALUES(' . $value . ')';
		}
		
		return $query;
	}
	
	
	/* update query, fungsi ini untuk menghasilkan query update
	 * parameter 
	 * @table : string
	 * @data : array
	 * @where : string
	 * 
	 * return : string
	 * 
	 * Contoh hasil :
	 * UPDATE tbl_a SET nim = '1000', nama = 'acong' WHERE id = '1000';
	 * 
	 * Contoh penggunaan :
	 
		 $data = array(
		 	'nim' => '1000',
		 	'nama' => 'acong' 	
		 );
		 
		 echo update('tbl_karyawan', $data, "WHERE id = '$id'");
	 */
	function update($table = '', $data = array(), $where = '')
	{
		$query = '';
		if(is_array($data)) {
			$total = count($data) - 1; $i = 0;
			$value = '';
			
			foreach($data as $key => $val) {
				$value .= $key . " = '" . $val . "'";
				$value .= ($i < $total) ? ',' : '' ; 
					
				++$i;
			}
			
			$query = 'UPDATE ' . $table . ' SET ' . $value . ' ' . $where;
		}
		
		return $query;
	}
	
	/* delete query, fungsi ini untuk menghasilkan query delete
	 * parameter 
	 * @table : string
	 * @pk : string
	 * @value : string
	 * 
	 * return : string
	 * 
	 * Contoh hasil :
	 * DELETE FROM tbl_a WHERE id = '1000';
	 * 
	 * Contoh penggunaan :
	 
		 
		 echo delete('tbl_karyawan', 'id', $id);
	 */
	function delete($table = '', $pk = '', $value = '', $where = '')
	{
		return 'DELETE FROM ' . $table . ' WHERE ' . $pk . " = '" . $value . "' " . $where;
	}
	
	/* select query, fungsi ini untuk menghasilkan query select
	 * parameter 
	 * @table : string
	 * @colomn : string
	 * @where : string
	 * 
	 * return : string
	 * 
	 * Contoh hasil :
	 * SELECT * FROM tbl_karyawan
	 * SELECT nim, nama FROM tbl_karyawan
	 * 
	 * Contoh penggunaan :
	 
		 $column = 'nim';
		 echo delete('tbl_karyawan', $column);
	 */
	function select($table = '', $column = '*', $where = '', $orderBy = '')
	{
		$query = '';
		(isset($column)) ? $query = 'SELECT ' . $column . ' FROM ' . $table . ' ' . $where . ' ' . $orderBy :  $query = 'SELECT * FROM ' . $table . ' ' . $where . ' ' . $orderBy ;
		return $query;
	}
	
	/* select query, fungsi ini untuk menghasilkan query select dengan join
	 * parameter 
	 * @table : string
	 * @whitelist : string
	 * @where : string
	 * @type : string
	 * 
	 * return : string
	 * 
	 * Contoh hasil :
	 * SELECT * FROM tbl_user u LEFT OUTER JOIN tbl_bagian b ON u.bagian_id = b.bagian_id LEFT OUTER JOIN tbl_sub_bagian s ON u.sub_bagian_id = s.sub_bagian_id
	 * 
	 * cara penggunaan :
	 * 
	 	$data = array(
			'u.tbl_user|b.tbl_bagian' => 'bagian_id|bagian_id',
			'u.tbl_user|s.tbl_sub_bagian' => 'sub_bagian_id|sub_bagian_id'
		);
		
		//$whitelist = 'u.user_id, b.nama_bagian, s.nama_sub_bagian';
		$whitelist = '*';
		$userID = '21';
		
		$query = selectJoin($data, $whitelist, "WHERE u.user_id = '$userID'", 'LEFT OUTER JOIN');
		echo $query;
	 * 
	 */
	function selectJoin($data = '', $whitelist = '*', $where = '', $type = 'INNER JOIN', $orderBy = '', $limit = '')
	{
		$query = '';
		
		if(is_array($data)) {
			$total = count($data);
			
			$column = '';
			($whitelist === '*' || $whitelist === '') ? $column = '*' : $column = $whitelist;
				
			$query = 'SELECT ' . $column . ' FROM ';
			
			$i = 0;
			foreach ($data as $t => $a) {
				// $t = table, $a = alias
				$table = explode('|', $t);
				$table1 = explode('.', $table[0]);
				$table2 = explode('.', $table[1]);
				
				$alias = explode('|', $a);
				
				$tableInit = ($i === 0) ? $table1[1] . ' ' . $table1[0] : '';
				
				$query .= $tableInit . ' ' . $type . ' ' . $table2[1] . ' ' . $table2[0] . ' ON ' . $table1[0] . '.' . $alias[0] . ' = ' . $table2[0] . '.' . $alias[1];
				++$i;
			}
		}
		
		return $query . ' ' . $where . ' ' . $orderBy . ' ' . $limit ;
	}
	
	/* generateCode, fungsi ini digunakan untuk mengenerate kode sesuai dengan yang kita inginkan 
	 * 
	 * Contoh hasil : 
	 * ED004
		
		Cara penggunaan :
		$lastID = 3;
		echo generateCode($lastID, 'ED', 5);

		$lastID bisa didapat dari query insert sebelumnya dan menggunakan mysql_insert_id();
		contoh : 
		$lastID = mysql_insert_id();
	 */
	function generateCode($lastID = '0', $format = '', $length = 0, $separator = '0')
	{
		$nextID = $lastID + 1;
		$leftLength = ($length - strlen($nextID)) - strlen($format); 
		
		return $format . str_repeat($separator, $leftLength) . $nextID;
	}

	
	