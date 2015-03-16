<?php

//CrEOF\Spatial\DBAL\Types\GeometryType
//

namespace PNC\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
//use CrEOF\Spatial\DBAL\Types\GeometryType;

class GeometryType extends Type{

    public function getSqlDeclaration(array $value, AbstractPlatform $platform){
        return 'geometry';
    }

    public function getName(){
        return 'geometry';
    }

    public function canRequireSQLConversion(){
        return true;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform){
        return json_encode($value);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform){
        return json_decode($value);
    }

    public function convertToDatabaseValueSQL($value, AbstractPlatform $platform){
        return sprintf('st_geomFromGeoJson(%s)', $value);
    }

    public function convertToPHPValueSQL($sqlExpr, $platform){
        return sprintf('st_asGeoJson(%s)', $sqlExpr);
    }

}
