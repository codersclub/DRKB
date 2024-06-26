---
Title: Число прописью на английском языке
Date: 01.01.2007
Source: Советы по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com) Сборник Kuliba
---


Число прописью на английском языке
========================

По русски это называется "сумма прописью".
Однажды потребовалось сделать то же самое, но на англицком...

Вариант 1:

    unit uNum2Str;
     
    // Possible enhancements
    // Move strings out to resource files
    // Put in a general num2str utility
     
    interface
     
    function Num2Dollars(dNum: double): string;
     
    implementation
     
    uses SysUtils;
     
    function LessThan99(dNum: double): string; forward;
    // floating point modulus
    function FloatMod(i, j: double): double;
    begin
      result := i - (Int(i / j) * j);
    end;
     
    function Hundreds(dNum: double): string;
    var
      workVar: double;
    begin
      if (dNum < 100) or (dNum > 999) then  raise Exception.Create('hundreds range exceeded');
      result := '';
      workVar := Int(dNum / 100);
      if workVar > 0 then result := LessThan99(workVar) + ' Hundred';
    end; 
     
    function OneToNine(dNum: Double): string;
    begin
      if (dNum < 1) or (dNum > 9) then raise exception.create('onetonine: value out of range');
      result := 'woops';
      if dNum = 1 then result := 'One' else 
       if dNum = 2 then result := 'Two' else 
        if dNum = 3 then result := 'Three' else 
         if dNum = 4 then result := 'Four' else 
          if dNum = 5 then result := 'Five' else 
           if dNum = 6 then result := 'Six' else 
            if dNum = 7 then result := 'Seven' else 
             if dNum = 8 then result := 'Eight' else 
              if dNum = 9 then result := 'Nine';
    end;
     
    function ZeroTo19(dNum: double): string;
    begin
      if (dNum < 0) or (dNum > 19) then  raise Exception.Create('Bad value in dNum');
      result := '';
      if dNum = 0 then result := 'Zero' else 
       if (dNum <= 1) and (dNum >= 9) then result := OneToNine(dNum) else 
        if dNum = 10 then result := 'Ten' else 
         if dNum = 11 then result := 'Eleven' else 
          if dNum = 12 then result := 'Twelve' else 
           if dNum = 13 then result := 'Thirteen' else 
            if dNum = 14 then result := 'Fourteen' else 
             if dNum = 15 then result := 'Fifteen' else 
              if dNum = 16 then result := 'Sixteen' else 
               if dNum = 17 then result := 'Seventeen' else 
                if dNum = 18 then result := 'Eighteen' else 
                 if dNum = 19 then result := 'Nineteen' else
                  result := 'woops!';
    end;
     
    function TwentyTo99(dNum: double): string;
    var  BigNum: string;
    begin
      if (dNum < 20) or (dNum > 99) then raise exception.Create('TwentyTo99: dNum out of range!');
      BigNum := 'woops';
      if dNum >= 90 then BigNum := 'Ninety' else 
       if dNum >= 80 then BigNum := 'Eighty' else 
        if dNum >= 70 then BigNum := 'Seventy' else 
         if dNum >= 60 then BigNum := 'Sixty' else 
          if dNum >= 50 then BigNum := 'Fifty' else 
           if dNum >= 40 then BigNum := 'Forty' else 
            if dNum >= 30 then BigNum := 'Thirty' else 
             if dNum >= 20 then BigNum := 'Twenty';
      // lose the big num
      dNum := FloatMod(dNum, 10);
      if dNum > 0.00 then
        result := BigNum + ' ' + OneToNine(dNum)
      else
        result := BigNum;
    end;
     
    function LessThan99(dNum: double): string;
    begin
      if dNum <= 19 then
        result := ZeroTo19(dNum)
      else
        result := TwentyTo99(dNum);
    end;
     
    function Num2Dollars(dNum: double): string;
    var
      centsString: string;
      cents: double;
      workVar: double;
    begin
      result := '';
      if dNum < 0 then raise Exception.Create('Negative numbers not supported');
      if dNum > 999999999.99 then
        raise Exception.Create('Num2Dollars only supports up to the millions at this point!');
      cents := (dNum - Int(dNum)) * 100.0;
      if cents = 0.0 then centsString := 'and 00/100 Dollars' else 
        if cents < 10 then centsString := Format('and 0%1.0f/100 Dollars', [cents]) else
          centsString := Format('and %2.0f/100 Dollars', [cents]);
     
      dNum := Int(dNum - (cents / 100.0)); // lose the cents
     
      // deal with million's
      if (dNum >= 1000000) and (dNum <= 999999999) then
        begin
          workVar := dNum / 1000000;
          workVar := Int(workVar);
          if (workVar <= 9) then result := ZeroTo19(workVar) else 
           if (workVar <= 99) then result := LessThan99(workVar) else 
            if (workVar <= 999) then result := Hundreds(workVar) else
              result := 'mill fubar';
          result := result + ' Million';
          dNum := dNum - (workVar * 1000000);
        end;
     
      // deal with 1000's
      if (dNum >= 1000) and (dNum <= 999999.99) then
        begin
          // doing the two below statements in one line of code yields some really
          // freaky floating point errors
          workVar := dNum / 1000;
          workVar := Int(workVar);
          if (workVar <= 9) then result := ZeroTo19(workVar) else 
           if (workVar <= 99) then result := LessThan99(workVar) else 
            if (workVar <= 999) then result := Hundreds(workVar) else
              result := 'thou fubar';
          result := result + ' Thousand';
          dNum := dNum - (workVar * 1000);
        end;
     
      // deal with 100's
      if (dNum >= 100.00) and (dNum <= 999.99) then
        begin
          result := result + ' ' + Hundreds(dNum);
          dNum := FloatMod(dNum, 100);
        end;
     
      // format in anything less than 100
      if (dNum > 0) or ((dNum = 0) and (Length(result) = 0)) then
        begin
          result := result + ' ' + LessThan99(dNum);
        end;
      result := result + ' ' + centsString;
    end;
     
    end.

------------------------------------------------------------------------

Вариант 2:

    function HundredAtATime(TheAmount: Integer): string;
    var
     
      TheResult: string;
    begin
     
      TheResult := '';
      TheAmount := Abs(TheAmount);
      while TheAmount > 0 do
        begin
          if TheAmount >= 900 then
            begin
              TheResult := TheResult + 'Nine hundred ';
              TheAmount := TheAmount - 900;
            end;
          if TheAmount >= 800 then
            begin
              TheResult := TheResult + 'Eight hundred ';
              TheAmount := TheAmount - 800;
            end;
          if TheAmount >= 700 then
            begin
              TheResult := TheResult + 'Seven hundred ';
              TheAmount := TheAmount - 700;
            end;
          if TheAmount >= 600 then
            begin
              TheResult := TheResult + 'Six hundred ';
              TheAmount := TheAmount - 600;
            end;
          if TheAmount >= 500 then
            begin
              TheResult := TheResult + 'Five hundred ';
              TheAmount := TheAmount - 500;
            end;
          if TheAmount >= 400 then
            begin
              TheResult := TheResult + 'Four hundred ';
              TheAmount := TheAmount - 400;
            end;
          if TheAmount >= 300 then
            begin
              TheResult := TheResult + 'Three hundred ';
              TheAmount := TheAmount - 300;
            end;
          if TheAmount >= 200 then
            begin
              TheResult := TheResult + 'Two hundred ';
              TheAmount := TheAmount - 200;
            end;
          if TheAmount >= 100 then
            begin
              TheResult := TheResult + 'One hundred ';
              TheAmount := TheAmount - 100;
            end;
          if TheAmount >= 90 then
            begin
              TheResult := TheResult + 'Ninety ';
              TheAmount := TheAmount - 90;
            end;
          if TheAmount >= 80 then
            begin
              TheResult := TheResult + 'Eighty ';
              TheAmount := TheAmount - 80;
            end;
          if TheAmount >= 70 then
            begin
              TheResult := TheResult + 'Seventy ';
              TheAmount := TheAmount - 70;
            end;
          if TheAmount >= 60 then
            begin
              TheResult := TheResult + 'Sixty ';
              TheAmount := TheAmount - 60;
            end;
          if TheAmount >= 50 then
            begin
              TheResult := TheResult + 'Fifty ';
              TheAmount := TheAmount - 50;
            end;
          if TheAmount >= 40 then
            begin
              TheResult := TheResult + 'Fourty ';
              TheAmount := TheAmount - 40;
            end;
          if TheAmount >= 30 then
            begin
              TheResult := TheResult + 'Thirty ';
              TheAmount := TheAmount - 30;
            end;
          if TheAmount >= 20 then
            begin
              TheResult := TheResult + 'Twenty ';
              TheAmount := TheAmount - 20;
            end;
          if TheAmount >= 19 then
            begin
              TheResult := TheResult + 'Nineteen ';
              TheAmount := TheAmount - 19;
            end;
          if TheAmount >= 18 then
            begin
              TheResult := TheResult + 'Eighteen ';
              TheAmount := TheAmount - 18;
            end;
          if TheAmount >= 17 then
            begin
              TheResult := TheResult + 'Seventeen ';
              TheAmount := TheAmount - 17;
            end;
          if TheAmount >= 16 then
            begin
              TheResult := TheResult + 'Sixteen ';
              TheAmount := TheAmount - 16;
            end;
          if TheAmount >= 15 then
            begin
              TheResult := TheResult + 'Fifteen ';
              TheAmount := TheAmount - 15;
            end;
          if TheAmount >= 14 then
            begin
              TheResult := TheResult + 'Fourteen ';
              TheAmount := TheAmount - 14;
            end;
          if TheAmount >= 13 then
            begin
              TheResult := TheResult + 'Thirteen ';
              TheAmount := TheAmount - 13;
            end;
          if TheAmount >= 12 then
            begin
              TheResult := TheResult + 'Twelve ';
              TheAmount := TheAmount - 12;
            end;
          if TheAmount >= 11 then
            begin
              TheResult := TheResult + 'Eleven ';
              TheAmount := TheAmount - 11;
            end;
          if TheAmount >= 10 then
            begin
              TheResult := TheResult + 'Ten ';
              TheAmount := TheAmount - 10;
            end;
          if TheAmount >= 9 then
            begin
              TheResult := TheResult + 'Nine ';
              TheAmount := TheAmount - 9;
            end;
          if TheAmount >= 8 then
            begin
              TheResult := TheResult + 'Eight ';
              TheAmount := TheAmount - 8;
            end;
          if TheAmount >= 7 then
            begin
              TheResult := TheResult + 'Seven ';
              TheAmount := TheAmount - 7;
            end;
          if TheAmount >= 6 then
            begin
              TheResult := TheResult + 'Six ';
              TheAmount := TheAmount - 6;
            end;
          if TheAmount >= 5 then
            begin
              TheResult := TheResult + 'Five ';
              TheAmount := TheAmount - 5;
            end;
          if TheAmount >= 4 then
            begin
              TheResult := TheResult + 'Four ';
              TheAmount := TheAmount - 4;
            end;
          if TheAmount >= 3 then
            begin
              TheResult := TheResult + 'Three ';
              TheAmount := TheAmount - 3;
            end;
          if TheAmount >= 2 then
            begin
              TheResult := TheResult + 'Two ';
              TheAmount := TheAmount - 2;
            end;
          if TheAmount >= 1 then
            begin
              TheResult := TheResult + 'One ';
              TheAmount := TheAmount - 1;
            end;
        end;
      HundredAtATime := TheResult;
    end;
     
    function Real2CheckAmount(TheAmount: Real): string;
    var
      IntVal: LongInt;
      TmpVal: Integer;
      TmpStr,
        RetVal: string;
    begin
     
      TheAmount := Abs(TheAmount);
     
      { центы }
      TmpVal := Round(Frac(TheAmount) * 100);
      IntVal := Trunc(TheAmount);
      TmpStr := HundredAtATime(TmpVal);
      if TmpStr = '' then TmpStr := 'Zero ';
      RetVal := TmpStr + 'cents';
      if IntVal > 0 then RetVal := 'dollars and ' + RetVal;
     
      { сотни }
      TmpVal := Round(Frac((IntVal * 1.0) / 1000.0) * 1000);
      IntVal := Trunc((IntVal * 1.0) / 1000.0);
      TmpStr := HundredAtATime(TmpVal);
      RetVal := TmpStr + RetVal;
     
      { тысячи }
      TmpVal := Round(Frac((IntVal * 1.0) / 1000.0) * 1000);
      IntVal := Trunc((IntVal * 1.0) / 1000.0);
      TmpStr := HundredAtATime(TmpVal);
      if TmpStr <> '' then
        RetVal := TmpStr + 'Thousand ' + RetVal;
     
      { миллионы }
      TmpVal := Round(Frac((IntVal * 1.0) / 1000.0) * 1000);
      IntVal := Trunc((IntVal * 1.0) / 1000.0);
      TmpStr := HundredAtATime(TmpVal);
      if TmpStr <> '' then
        RetVal := TmpStr + 'Million ' + RetVal;
     
      { миллиарды }
      TmpVal := Round(Frac((IntVal * 1.0) / 1000.0) * 1000);
      IntVal := Trunc((IntVal * 1.0) / 1000.0);
      TmpStr := HundredAtATime(TmpVal);
      if TmpStr <> '' then
        RetVal := TmpStr + 'Billion ' + RetVal;
     
      Real2CheckAmount := RetVal;
    end;

**Комментарий:**

Хммммм... вроде бы работает, но как все громоздко и неуклюже...

Добавьте в код немного рекурсии и вы получите более
элегантную программу. :)))

    unit Unit1;
     
    interface
     
    uses
     
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      StdCtrls;
     
    type
     
      TForm1 = class(TForm)
        num: TEdit;
        spell: TEdit;
        Button1: TButton;
        procedure Button1Click(Sender: TObject);
      private
    { Private declarations }
        function trans9(num: integer): string;
        function trans19(num: integer): string;
        function trans99(num: integer): string;
        function IntToSpell(num: integer): string;
      public
    { Public declarations }
      end;
     
    var
     
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
    function TForm1.IntToSpell(num: integer): string;
    var
     
      spell: string;
      hspell: string;
      hundred: string;
      thousand: string;
      tthousand: string;
      hthousand: string;
      million: string;
    begin
     
      if num &lg; 10 then
        spell := trans9(num);
    {endif}
      if (num < 20) and (num > 10) then
        spell := trans19(num);
    {endif}
      if (((num < 100) and (num > 19)) or (num = 10)) then
        begin
          hspell := copy(IntToStr(num), 1, 1) + '0';
          spell := trans99(StrToInt(hspell));
          hspell := copy(IntToStr(num), 2, 1);
          spell := spell + ' ' + IntToSpell(StrToInt(hspell));
        end;
     
      if (num < 1000) and (num > 100) then
        begin
          hspell := copy(IntToStr(num), 1, 1);
          hundred := IntToSpell(StrToInt(hspell));
          hspell := copy(IntToStr(num), 2, 2);
          hundred := hundred + ' hundred and ' + IntToSpell(StrToInt(hspell));
          spell := hundred;
        end;
     
      if (num < 10000) and (num > 1000) then
        begin
          hspell := copy(IntToStr(num), 1, 1);
          thousand := IntToSpell(StrToInt(hspell));
          hspell := copy(IntToStr(num), 2, 3);
          thousand := thousand + ' thousand ' + IntToSpell(StrToInt(hspell));
          spell := thousand;
        end;
     
      if (num < 100000) and (num > 10000) then
        begin
          hspell := copy(IntToStr(num), 1, 2);
          tthousand := IntToSpell(StrToInt(hspell));
          hspell := copy(IntToStr(num), 3, 3);
          tthousand := tthousand + ' thousand ' + IntToSpell(StrToInt(hspell));
          spell := tthousand;
        end;
     
      if (num < 1000000) and (num > 100000) then
        begin
          hspell := copy(IntToStr(num), 1, 3);
          hthousand := IntToSpell(StrToInt(hspell));
          hspell := copy(IntToStr(num), 4, 3);
          hthousand := hthousand + ' thousand and ' +
            IntToSpell(StrToInt(hspell));
     
          spell := hthousand;
        end;
     
      if (num < 10000000) and (num > 1000000) then
        begin
          hspell := copy(IntToStr(num), 1, 1);
          million := IntToSpell(StrToInt(hspell));
          hspell := copy(IntToStr(num), 2, 6);
          million := million + ' million and ' + IntToSpell(StrToInt(hspell));
          spell := million;
        end;
     
      IntToSpell := spell;
     
    end;
     
    function TForm1.trans99(num: integer): string;
    var
     
      spell: string;
    begin
     
      case num of
        10: spell := 'ten';
        20: spell := 'twenty';
        30: spell := 'thirty';
        40: spell := 'fourty';
        50: spell := 'fifty';
        60: spell := 'sixty';
        70: spell := 'seventy';
        80: spell := 'eighty';
        90: spell := 'ninty';
      end;
      trans99 := spell;
    end;
    function TForm1.trans19(num: integer): string;
    var
     
      spell: string;
    begin
     
      case num of
        11: spell := 'eleven';
        12: spell := 'twelve';
        13: spell := 'thirteen';
        14: spell := 'fourteen';
        15: spell := 'fifteen';
        16: spell := 'sixteen';
        17: spell := 'seventeen';
        18: spell := 'eighteen';
        19: spell := 'nineteen';
      end;
      trans19 := spell;
    end;
    function TForm1.trans9(num: integer): string;
    var
     
      spell: string;
    begin
     
      case num of
        1: spell := 'one';
        2: spell := 'two';
        3: spell := 'three';
        4: spell := 'four';
        5: spell := 'five';
        6: spell := 'six';
        7: spell := 'seven';
        8: spell := 'eight';
        9: spell := 'nine';
      end;
      trans9 := spell;
    end;
    procedure TForm1.Button1Click(Sender: TObject);
    var
     
      numb: integer;
    begin
     
      spell.text := IntToSpell(StrToInt(num.text));
    end;

