---
Title: Как отключить комбинацию Alt+Tab
Date: 01.01.2007
---


Как отключить комбинацию Alt+Tab
================================

::: {.date}
01.01.2007
:::

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

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
