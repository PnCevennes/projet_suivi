<?php
namespace PNC\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;


class PgArrayTextType extends Type{
    const TEXTARRAY = 'varchar[]';

    public function getSqlDeclaration(array $value, AbstractPlatform $platform){
        $platform->getDoctrineTypeMapping('TEXTARRAY');
    }

    public function getName(){
        return self::TEXTARRAY;
    }

    public function canRequireSQLConversion(){
        return true;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform){
        settype($value, 'array'); // can be called with a scalar or array
        $result = array();
        foreach ($value as $t) {
            if (is_array($t)) {
                $result[] = to_pg_array($t);
            } else {
                $t = str_replace('"', '\\"', $t); // escape double quote
                if (! is_numeric($t)) // quote only non-numeric values
                    $t = '"' . $t . '"';
                $result[] = $t;
            }
        }
        return '{' . implode(",", $result) . '}'; // format
    }

    public function convertToPHPValue($value, AbstractPlatform $platform){
        return explode('","', trim($value, '{""}') );
    }

    /*public function convertToDatabaseValueSQL($value, AbstractPlatform $platform){
          @TODO
    }

    public function convertToPHPValueSQL($sqlExpr, $platform){
        @TODO
    }*/

}
