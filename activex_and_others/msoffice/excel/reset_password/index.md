---
Title: Как снять пароль с Excel файла?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как снять пароль с Excel файла?
===============================


    {
    Today I want to show how you may load some xls-file that is 
    password-protected, and how to save xls into another file 
    but without protection.
    Just replace there file names and password...
    }
     
    var
    xls, xlw: Variant;
    begin
    {load MS Excel}
    xls := CreateOLEObject('Excel.Application');
     
    {open your xls-file}
    xlw := xls.WorkBooks.Open(FileName := 'd:\book1.xls', Password := 'qq', ReadOnly := True);
    {save with other file name}
    xlw.SaveAs(FileName := 'd:\book2.xls', Password := '');
     
    {unload MS Excel}
    xlw := UnAssigned;
    xls := UnAssigned;
    end;

