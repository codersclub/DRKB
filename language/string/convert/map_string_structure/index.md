---
Title: Отобразить строку на определенную структуру
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Отобразить строку на определенную структуру
===========================================

    type
      TEmployee = record 
        cNo: array [0..3] of Char; 
        cName: array [0..7] of Char; 
      end; 
      PEmployee = ^TEmployee; 
     
    procedure ParseData; 
    const 
      sData = '0001Mosquito'; 
    var 
      sNo, sName: string; 
    begin 
      with PEmployee(Pointer((@sData)^))^ do  
      begin 
        sNo   := cNo;      // sNo = '0001' 
        sName := cName;    // sName = 'Mosquito' 
      end 
    end;

