---
Title: Как отключить комбинацию Alt+Tab
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Как отключить комбинацию Alt+Tab
================================

Если вы хотите зло подшутить над глупым пользователем, а он оказывается
не такой уж и глупый, и усиленно пытается переключиться на другую
программу, вы можете круто его обломать:

    procedure TurnSysKeysOff;
    var
      OldVal: LongInt;
    begin
      SystemParametersInfo (97, Word (True), @OldVal, 0);
    end;
     
    procedure TurnSysKeysBackOn;
    var
      OldVal: LongInt;
    begin
      SystemParametersInfo (97, Word (False), @OldVal, 0);
    end;


