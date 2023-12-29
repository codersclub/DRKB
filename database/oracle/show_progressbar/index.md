---
Title: Как при выполнении долгой операции в Oracle показать прогресс бар?
Author: Philip A. Milovanov   ( http://korys.chat.ru )
Date: 01.01.2007
---


Как при выполнении долгой операции в Oracle показать прогресс бар?
==================================================================

::: {.date}
01.01.2007
:::

Автор: Philip A. Milovanov   ( http://korys.chat.ru )

Ниже приведен пример, как это сделать при помощи Direct Oracle Access,
надеюсь этот кусок кода несложно запустить в отдельном процессе, а в
другом можно запустить перемесчатель прогресс бара. Есть готовая
компонента, могу поделиться.

    //на создании потока вставим то, что будет выбирать необходимую информацию
     
    Self.fods.SQL.Text:='SELECT SOFAR FROM V$SESSION_LONGOPS WHERE CONTEXT=:FK_ID';
    Self.fods.DeclareVariable('FK_ID',otInteger);
    Self.fods.SetVariable('FK_ID',ID);
     
    //На выполнение потока вешаем открытие/закрытие TOracleDataSet
    while (Terminated = false) do
      begin
        Self.fods.Close;
        Self.fods.Open;
        Self.fpb.Progress := Self.fods.FieldByName('SOFAR').AsInteger;
    //^^^^Эта строчка как раз и устанавливает нужный прогрессбар в нужную позицию...
      end;

Ну и соответсвенно перед выполнением всего этого дела необходимо
выставить максимальное число (100%) :

PROCEDURE SETMaxValue(nVal IN NUMBER);

Минимальное:

PROCEDURE SETMinValue(nVal IN NUMBER);

Значение шага:

PROCEDURE SetStepValue(nValue IN NUMBER);

Вышеприведенный кусок кода - клиентская часть, но есть и \"подводный
камень\" - серверная часть... Данный метотод подкодит только для
функций, процедур и пактеов, в которых вы можете написать вставить
следущую строчку:

PROGRESS\_BAR.STEPIT;

Код пакета PROGRESS\_BAR приведен ниже:

    create or replace package PROGRESS_BAR 
    IS 
    -- Wrote by Philip A. Milovanov 
    nMaxValue NUMBER:=0; 
    nMinValue NUMBER:=0; 
    nCurrentValue NUMBER:=0; 
    nStepValue NUMBER:=1; 
    nID PLS_INTEGER; 
    slno PLS_INTEGER; 
    target PLS_INTEGER; 
    PROCEDURE SETMaxValue(nVal IN NUMBER); 
    PROCEDURE SETMinValue(nVal IN NUMBER); 
    FUNCTION INIT RETURN NUMBER; 
    PROCEDURE StepIt; 
    PROCEDURE SetStepValue(nValue IN NUMBER); 
    PROCEDURE StepIt(C IN NUMBER);
    END; -- Package Specification PROGRESS_BAR 
    /
    --Сам пакет:
    Create or Replace Package Body PROGRESS_BAR 
    IS 
    -- Wrote by Philip A. Milovanov 
    PROCEDURE SETMaxValue(nVal IN NUMBER) IS 
    BEGIN 
    if nVal<nMinValue THEN 
    RAISE_APPLICATION_ERROR(-20001,'&Igrave;&egrave;&iacute;&egrave;&igrave;&agrave;&euml;&uuml;&iacute;&icirc;&aring; &ccedil;&iacute;&agrave;&divide;&aring;&iacute;&egrave;&aring; &iacute;&aring; &auml;&icirc;&euml;&aelig;&iacute;&icirc; &aacute;&ucirc;&ograve;&uuml; &aacute;&icirc;&euml;&uuml;&oslash;&aring; &igrave;&agrave;&ecirc;&ntilde;&egrave;&igrave;&agrave;&euml;&uuml;&iacute;&icirc;&atilde;&icirc; &igrave;&egrave;&iacute;:'||nMinValue||',&igrave;&agrave;&ecirc;&ntilde;:'||nVal); 
    END IF; 
    nMaxValue:=nVal; 
    END; 
    PROCEDURE SETMinValue(nVal IN NUMBER) IS 
    BEGIN 
    if nVal>nMaxValue THEN 
    RAISE_APPLICATION_ERROR(-20001,'&Igrave;&egrave;&iacute;&egrave;&igrave;&agrave;&euml;&uuml;&iacute;&icirc;&aring; &ccedil;&iacute;&agrave;&divide;&aring;&iacute;&egrave;&aring; &iacute;&aring; &auml;&icirc;&euml;&aelig;&iacute;&icirc; &aacute;&ucirc;&ograve;&uuml; &aacute;&icirc;&euml;&uuml;&oslash;&aring; &igrave;&agrave;&ecirc;&ntilde;&egrave;&igrave;&agrave;&euml;&uuml;&iacute;&icirc;&atilde;&icirc; &igrave;&egrave;&iacute;:'||nVal||',&igrave;&agrave;&ecirc;&ntilde;:'||nMaxValue); 
    END IF; 
    nMinValue:=nVal; 
    END; 
    FUNCTION INIT RETURN NUMBER IS 
    CURSOR c IS SELECT OBJECT_ID FROM ALL_OBJECTS WHERE OBJECT_NAME='PROGRESS_BAR'; 
    i NUMBER; 
    BEGIN 
    OPEN c; 
    FETCH c INTO target; 
    CLOSE c; 
    SELECT SEQ_TPROCESS_BAR.NEXTVAL INTO i FROM DUAL; 
    nCurrentValue:=nMinValue; 
    nID:=DBMS_APPLICATION_INFO.set_session_longops_nohint; 
    DBMS_APPLICATION_INFO.SET_SESSION_LONGOPS(nID,slno,'CALCULATING REPORT',target,i,nCurrentValue,nMaxValue,'PROGRESS BAR INFO',NULL); 
    RETURN i; 
    END; 
    PROCEDURE StepIt IS 
    BEGIN 
    nCurrentValue:=nCurrentValue+nStepValue; 
    DBMS_APPLICATION_INFO.SET_SESSION_LONGOPS(nID,slno,'CALCULATING REPORT',target,nMinValue,nCurrentValue,nMaxValue,'PROGRESS BAR INFO',NULL); 
    END; 
    PROCEDURE SetStepValue(nValue IN NUMBER) IS 
    BEGIN 
    nStepValue:=nValue; 
    END; 
    PROCEDURE StepIt(C IN NUMBER) IS 
    BEGIN 
    nCurrentValue:=nCurrentValue+c; 
    DBMS_APPLICATION_INFO.SET_SESSION_LONGOPS(nID,slno,'CALCULATING REPORT',target,nMinValue,nCurrentValue,nMaxValue,'PROGRESS BAR INFO',NULL); 
    END; 
    END; 

Взято из <https://forum.sources.ru>
