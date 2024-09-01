---
Title: Получение типа клавиатуры
Date: 01.01.2007
---


Получение типа клавиатуры
=========================

Вариант 1:

    function GettingKeybType: string;  //Win95 or later and NT3.1 or later
    var
      Flag:   integer;
    begin
      Flag:=0;
      Case GetKeyboardType(Flag) of
        1:  Result:='IBM PC/XT or compatible (83-key) keyboard';
        2:  Result:='Olivetti "ICO" (102-key) keyboard';
        3:  Result:='IBM PC/AT (84-key) or similar keyboard';
        4:  Result:='IBM enhanced (101- or 102-key) keyboard';
        5:  Result:='Nokia 1050 and similar keyboards';
        6:  Result:='Nokia 9140 and similar keyboards';
        7:  Result:='Japanese keyboard';
      end;
    end;

------------------------------------------------------------------------

Вариант 2:

Source: <https://www.swissdelphicenter.ch>

    // The GetKeyboardType function retrieves information about the current keyboard. 
     
    function KeyBoardType: string;
     begin
       case GetKeyboardType(0) of
         1: Result := 'IBM PC/XT or compatible (83-key) keyboard';
         2: Result := 'Olivetti "ICO" (102-key) keyboard';
         3: Result := 'IBM PC/AT (84-key) or similar keyboard';
         4: Result := 'IBM enhanced or compatible';
         5: Result := 'Nokia 1050 and similar keyboards';
         6: Result := 'Nokia 9140 and similar keyboards';
         7: Result := 'Japanese keyboard'
           else
              Result := 'Unrecognized keyboard type';
       end;
     end;
     
     function KeyBoardSubype: Integer;
     begin
       Result := GetKeyboardType(1);
     end;
     
     function NumberOfFunctionKeys: string;
     begin
       case GetKeyboardType(3) of
         1: Result := '20';
         2: Result := '12/18';
         3: Result := '10';
         4: Result := '12';
         5: Result := '10';
         6: Result := '24';
         7: Result := 'Hardware dependent'
           else
              Result := 'N/A';
       end;
     end;
     
     procedure TForm1.Button1Click(Sender: TObject);
     begin
       label1.Caption := Format('Keyboard Type: %s', [KeyBoardType]);
       Label2.Caption := Format('Keyboard Subtype: %d', [KeyBoardSubype]);
       Label3.Caption := Format('Keyboard Subtype: %s', [NumberOfFunctionKeys]);
     end;

