---
Title: Как настроить табуляцию в компоненте TMemo?
Date: 01.01.2007
---


Как настроить табуляцию в компоненте TMemo?
===========================================

Вариант 1:

Source: <https://blackman.wp-club.net/>

Пошлите в Memo сообщение EM\_SETTABSTOPS


------------------------------------------------------------------------

Вариант 2:

Source: Королевство Дельфи (https://delphi.vitpc.com/)

    procedure TForm1.FormCreate(Sender: TObject);
    var
      DialogUnitsX: LongInt;
      PixelsX: LongInt;
      i: integer;
      TabArray: array[0..4] of integer;
    begin
      Memo1.WantTabs := true;
      DialogUnitsX := LoWord(GetDialogBaseUnits);
      PixelsX := 20;
      for i := 1 to 5 do
        begin
          TabArray[i - 1] := ((PixelsX * i) * 4) div DialogUnitsX;
        end;
      SendMessage(Memo1.Handle,
        EM_SETTABSTOPS, 5, LongInt(@TabArray));
      Memo1.Refresh;
    end;

Взято из "DELPHI VCL FAQ", Перевод с английского.

Подборку, перевод и адаптацию материала подготовил Aziz(JINX)

специально для [Королевства Дельфи](https://delphi.vitpc.com/)

------------------------------------------------------------------------

Вариант 3:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Для этого надо послать сообщение EM\_SetTabStops компоненте TMemo, в
котором необходимо указать два параметра. Количество передаваемых
значений и величины табуляций.

Если первый параметр равняется нулю, то второй параметр игнорируется и
величина табуляции сбрасывается в значение по умолчанию (32). Иначе,
устанавливается величина указанная во втором параметре, причем, при
единичном значении все величины табуляций будут равны, а при большем
значении величины берутся из переданного массива.

    {Установка одной величины табуляции}
    const
      TabInc: LongInt = 40;
     
    begin
      SendMessage(Memo1.Handle, EM_SetTabStops, 1, Longint(@TabInc));
    end;
     
    ...
     
    {Установка двух величин табуляции}
    const
      TabInc: array [1..2] of LongInt = (10, 30);
     
    begin
      SendMessage(Memo1.Handle, EM_SetTabStops, 2, Longint(@TabInc));
    end;


