<?php

class Query{
    public static $GET_DEV_BY_SN = "select typ.nazwa as typ_nazwa, model.nazwa as model_nazwa, urzadzenie.sn, urzadzenie.sn2, urzadzenie.opis, "
                        ."lokalizacja.nazwa as lok_nazwa, urzadzenie.serwis, urzadzenie.stan, urzadzenie.utyl, urzadzenie.id from urzadzenie "
                        . "join typ on typ.id=urzadzenie.typ_id "
                        . "join model on model.id=urzadzenie.model_id "
                        . "join lokalizacja on lokalizacja.id=urzadzenie.lok_id "
                        . "where urzadzenie.sn like ? or urzadzenie.sn2 like ?;";
    
    public static $GET_DEV_HIST = "select typ.nazwa as typ_nazwa, model.nazwa as model_nazwa, urzadzenie.sn, urzadzenie.sn2, urzadzenie.opis, "
                        ."lokalizacja.nazwa as lok_nazwa, urzadzenie.serwis, urzadzenie.stan, urzadzenie.fv, urzadzenie.utyl, urzadzenie.czas_op from urzadzenie "
                        . "join typ on typ.id=urzadzenie.typ_id "
                        . "join model on model.id=urzadzenie.model_id "
                        . "join lokalizacja on lokalizacja.id=urzadzenie.lok_id "
                        . "where urzadzenie.sn like ? or urzadzenie.sn2 like ? union "
                        ."select typ.nazwa as typ_nazwa, model.nazwa as model_nazwa, hist.sn, hist.sn2, hist.opis, "
                        ."lokalizacja.nazwa as lok_nazwa, hist.serwis, hist.stan, hist.fv, hist.utyl, hist.czas_op from hist "
                        . "join typ on typ.id=hist.typ_id "
                        . "join model on model.id=hist.model_id "
                        . "join lokalizacja on lokalizacja.id=hist.lok_id "
                        . "where hist.sn like ? or hist.sn2 like ? order by czas_op desc;";
    
    public static $GET_DEV_FROM_LOK = "select model.nazwa as model_nazwa, urzadzenie.stan, urzadzenie.sn, urzadzenie.sn2, urzadzenie.opis, urzadzenie.id from urzadzenie "
                        . "join model on model.id=urzadzenie.model_id "
                        . "where urzadzenie.lok_id=? and urzadzenie.typ_id=? and urzadzenie.serwis=false and urzadzenie.rez=false and urzadzenie.utyl=false order by urzadzenie.stan desc, model.nazwa asc;";
    
    public static $GET_TYPES = "select id, nazwa from typ;";
    
    public static $GET_VIS_LOC = "select id, nazwa, skrot from lokalizacja where widoczna=true order by nazwa asc;";
    
    public static $GET_MODELS = "select id, nazwa from model;";
    
    public static $GET_ALL_LOC = "select nazwa, skrot, widoczna from lokalizacja;";
    
    public static $GET_ALL_PROT = "select protokol.id, lokalizacja.nazwa as nazwa_lok, lokalizacja.skrot, protokol.osoba, uzytkownik.login, protokol.data, protokol.wro from protokol "
                        ."join lokalizacja on lokalizacja.id=protokol.lok_id "
                        ."join uzytkownik on uzytkownik.id=protokol.uzytkownik_id order by id desc;";
    
    public static $GET_PROT_BY_ID = "select lokalizacja.nazwa as nazwa_lok, lokalizacja.skrot, protokol.osoba, protokol.data, protokol.poz_urz, protokol.zlecajacy from protokol "
                        ."join lokalizacja on lokalizacja.id=protokol.lok_id where protokol.id=?;";
    
    public static $GET_DEV_FROM_PROT = "select typ.nazwa as typ_nazwa, model.nazwa as model_nazwa, urzadzenie.sn, urzadzenie.sn2 from urzadzenie "
                        ."join typ on typ.id=urzadzenie.typ_id "
                        ."join model on model.id=urzadzenie.model_id where urzadzenie.id in(select urzadzenie_id from prot_urz where protokol_id=?);";

    public static $GET_LOC_BY_SHORT_NAME = "select id from lokalizacja where skrot=?;";
    
    public static $GET_DEV_TO_FV = "select model.nazwa as model_nazwa, urzadzenie.stan, urzadzenie.sn, urzadzenie.sn2, lokalizacja.nazwa as lok_nazwa, lokalizacja.skrot as skrot, urzadzenie.opis, urzadzenie.id from urzadzenie "
                        . "join model on model.id=urzadzenie.model_id "
                        . "join lokalizacja on lokalizacja.id=urzadzenie.lok_id "
                        . "where urzadzenie.lok_id!=1 and urzadzenie.typ_id=? and urzadzenie.serwis=false and urzadzenie.rez=false and urzadzenie.fv=false and urzadzenie.utyl=false;";
    
    public static $GET_DEV_IN_SERVICE = "select typ.nazwa as typ_nazwa, model.nazwa as model_nazwa, urzadzenie.sn, urzadzenie.sn2, urzadzenie.opis, urzadzenie.id from urzadzenie "
                        . "join typ on typ.id=urzadzenie.typ_id "
                        . "join model on model.id=urzadzenie.model_id "
                        . "where urzadzenie.lok_id=1 and urzadzenie.serwis=1 and urzadzenie.rez=0 and urzadzenie.utyl=0 order by typ_nazwa asc;";
    
    public static $INSERT_DEVICE = "insert into urzadzenie values(null,?,?,?,?,?,?,false,?,false,false,false,null);";
    
    public static $INSERT_MODEL = "insert into model values(null,?);";
    
    public static $INSERT_LOCATION = "insert into lokalizacja values(null,?,?,?);";
    
    public static $INSERT_TYPE = "insert into typ values(null,?);";
    
    public static $GET_DEV_FOR_UPD = "select * from urzadzenie where id=? for update;";
    
    public static $UPDATE_DEV_LOC = "update urzadzenie set lok_id=? where id=?";
    
    public static $UPDATE_DEV_RES = "update urzadzenie set rez=? where id=?";
    
    public static $GET_PROT_FOR_UPD = "select * from protokol where id=? for update;";
    
    public static $UPDATE_PROT_WRO = "update protokol set wro=1 where id=?;";
    
    public static $GET_BROKEN_DEV = "select id from urzadzenie where id=? and stan='N';";

    public static $UPDATE_DEV_SERV = "update urzadzenie set serwis=? where id=?;";

    public static $CALL_PROC_TWO_PARAMS = "call proc_name(?, ?);";

    public static $RETURN_DEV_FROM_SERV = "update urzadzenie set serwis=0, stan='S', opis='', lok_id=1 where id=?;";

    public static $UPDATE_DEV_FV = "update urzadzenie set fv=1 where id=?;";

    public static $INSERT_PROTOCOL = "insert into protokol values (null,?,?,?,?,?,0,?);";

    public static $INSERT_PROT_URZ = "insert into prot_urz values (null,?,?);";

    public static $UPDATE_DEV_LOC_AND_RES = "update urzadzenie set lok_id=?, rez=0 where id=?";

    public static $GET_WORKING_DEV_FROM_LOK = "select model.nazwa as model_nazwa, urzadzenie.stan, urzadzenie.sn, urzadzenie.sn2, urzadzenie.opis, urzadzenie.id "                ."from urzadzenie join model on model.id=urzadzenie.model_id "
                        . "where urzadzenie.lok_id=? and urzadzenie.typ_id=? and urzadzenie.serwis=false and urzadzenie.rez=false and urzadzenie.stan='S' and urzadzenie.utyl=false order by model.nazwa asc;";

    public static $UPDATE_DEV_UTYL = "update urzadzenie set utyl=1 where id=?;";

    public static $UPDATE_DEV_DESC = "update urzadzenie set opis=? where id=?";

    public static $GET_DEVS_HIST_BY_DATE = "select typ.nazwa as typ_nazwa, model.nazwa as model_nazwa, urzadzenie.sn, urzadzenie.sn2, urzadzenie.opis, "
                        ."lokalizacja.nazwa as lok_nazwa, urzadzenie.serwis, urzadzenie.stan, urzadzenie.fv, urzadzenie.utyl, urzadzenie.czas_op from urzadzenie "
                        . "join typ on typ.id=urzadzenie.typ_id "
                        . "join model on model.id=urzadzenie.model_id "
                        . "join lokalizacja on lokalizacja.id=urzadzenie.lok_id "
                        . "where urzadzenie.czas_op >= ? and urzadzenie.typ_id=? union "
                        ."select typ.nazwa as typ_nazwa, model.nazwa as model_nazwa, hist.sn, hist.sn2, hist.opis, "
                        ."lokalizacja.nazwa as lok_nazwa, hist.serwis, hist.stan, hist.fv, hist.utyl, hist.czas_op from hist "
                        . "join typ on typ.id=hist.typ_id "
                        . "join model on model.id=hist.model_id "
                        . "join lokalizacja on lokalizacja.id=hist.lok_id "
                        . "where hist.czas_op >= ? and hist.typ_id=? order by model_nazwa, sn, czas_op desc;";

    public static $GET_DEVS_HIST_BY_DATE_SPEC_SORT = "select typ.nazwa as typ_nazwa, model.nazwa as model_nazwa, urzadzenie.sn, urzadzenie.sn2, urzadzenie.opis, "
                        ."lokalizacja.nazwa as lok_nazwa, urzadzenie.serwis, urzadzenie.stan, urzadzenie.fv, urzadzenie.utyl, urzadzenie.czas_op from urzadzenie "
                        . "join typ on typ.id=urzadzenie.typ_id "
                        . "join model on model.id=urzadzenie.model_id "
                        . "join lokalizacja on lokalizacja.id=urzadzenie.lok_id "
                        . "where urzadzenie.czas_op >= ? and urzadzenie.typ_id=? union "
                        ."select typ.nazwa as typ_nazwa, model.nazwa as model_nazwa, hist.sn, hist.sn2, hist.opis, "
                        ."lokalizacja.nazwa as lok_nazwa, hist.serwis, hist.stan, hist.fv, hist.utyl, hist.czas_op from hist "
                        . "join typ on typ.id=hist.typ_id "
                        . "join model on model.id=hist.model_id "
                        . "join lokalizacja on lokalizacja.id=hist.lok_id "
                        . "where hist.czas_op >= ? and hist.typ_id=? order by czas_op desc;";
} 
