<?php

namespace PNC\Utils;
use CrEOF\Spatial\PHP\Types\Geometry\Point;

class GeometryService{

    public function getPoint($coords){
        return new Point($coords[0][0], $coords[0][1], 4326);
    }

    /*
    public function lineStringJsonToWKT($json_line){
        $coords_line = array();
        foreach($json_line['coordinates'] as $coords){
            $coords_line[] = sprintf('%s %s', $coords[0], $coords[1]);
        }
        return 'LINESTRING(' . implode(', ', $coords_line) . ')';
    }

    public function polygonJsonToWKT($json_poly){
        $sub_polys = array();
        foreach($json_poly['coordinates'] as $sub_poly){
            $coords_line = array();
            foreach($sub_poly as $coords){
                $coords_line[] = sprintf('%s %s', $coords[0], $coords[1]);
            }
            $sub_polys[] = '(' . implode(', ', $coords_line) . ')';
        }
        return 'POLYGON(' . implode(', ', $sub_polys) . ')';
    }
     */
}
