---
Title: Отобразить строку на определенную структуру
Date: 01.01.2007
---


Отобразить строку на определенную структуру
===========================================

::: {.date}
01.01.2007
:::

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
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

 
