<?php

require_once 'class.database.php';

class Article extends DB {

    public $table = '';

    function __construct(){
        parent::__construct();
        $this->table = "articles";
    }
    
    public function getById(int $id){
        parent::get($this->table, $id);
        if(isset($this->raw)){
            $this->raw->price_dolar = number_format($this->raw->price * 200, 2, '.', ',');
        }
        return $this->raw;
    }

    public function getAll(){
        parent::get($this->table);
        if($row = parent::first()){
            $this->raw = [];
            do {
                $row->price_dolar = number_format($row->price * 200, 2, '.', ',');
                array_push($this->raw, $row);
            } while ($row = parent::next());
        }
        return $this->raw;
    }

    public function new(array $record){
        if($record['name']){ $record['name'] = $this->realEscape($record['name']); }
        return parent::create($this->table, $record);
    }

    public function edit(array $record, string $where = ""){
        return parent::update($this->table, $record, $where);
    }
}