<?php
function assign_role($data){
    switch($data){
        case 'pos':
            $role = 'gu';
            break;
        case 'group':
            $role = 'fr';
            break;
        case 'section':
            $role = 'sh';
            break;
        case 'dept':
            $role = 'mg';
            break;
        case 'deptAcc':
            $role = 'mg';
            break;
        case 'division':
            $role = 'mg';
            break;
    }
    return $role;

}