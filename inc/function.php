<?php

function userConnected(){
if(!isset($_SESSION['membre'])){
    return false;
}
else{
    return true;
}
};


function userisAdmin(){
if(userConnected() && $_SESSION['membre']['status'] == 1){
    return true;
}
else{
    return false;
}
};
