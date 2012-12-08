---
Title: Сase для строки
Date: 01.01.2007
---


Сase для строки
===============

::: {.date}
01.01.2007
:::

    const
      vlist = 'первый, второй, третий';
     
    var
      Values: TStringList;
     
    procedure SetValues(VL : TStringList; S: String);
    var
      I : Integer;
    begin
      VL.CommaText := S;
      for I := 0 to CL.Count-1 do
        VL.Objects[I] := Pointer(I);
      VL.Sorted := True;
    end;
     
    function GetValueIndex(VL : TStringList; Match: String): Integer;
    begin
      Result := VL.IndexOf(Match);
      if Result >= 0 then
        Result := Integer(VL.Objects[Result]);
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      case GetValueIndex(Values, Edit1.Text) of
        -1: {не найден} ;
         0: Caption := '0';
         1: Caption := '1';
         2: Caption := '2';
      end;
    end;
     
    initialization
      VL := TStringList.Create;
      SetValues(VL, vlist);
     
    finalization
      VL.Free;
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
