---
Title: Как округлять до сотых в большую сторону?
Author: Vit
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Как округлять до сотых в большую сторону?
=========================================

Прибавляешь 0.5, затем  отбрасываешь дробную часть:

    Uses Math;  
     
    Function RoundMax(Num:real; prec:integer):real; 
    begin 
      result:=roundto(num+Power(10, prec-1)*5, prec); 
    end;

До сотых соответственно будет:

    Function RoundMax100(Num:real):real; 
     
    begin 
      result:=round(num*100+0.5)/100; 
    end; 

