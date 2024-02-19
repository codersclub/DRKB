---
Title: Определить, что текстовое поле для ввода пароля
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Определить, что текстовое поле для ввода пароля
===============================================


    // Determine, if a Edit Field has password characters 
    // Herausfinden, ob das Edit Feld Passwort Charakter hat 
    function HasPasswordChar(AHandle: HWND): Boolean;
     var
       dwStyle: DWORD;
     begin
       dwStyle := GetWindowLong(AHandle, GWL_STYLE);
       Result := (dwStyle and ES_PASSWORD) = ES_PASSWORD;
     end;
     
     // Set password characters for the Edit Field 
    // Passwort Charakter fur ein Edit Feld setzen 
    procedure SetPasswordChar(AHandle: HWND; Value: Char);
     var
       S: String;
       len: Integer;
     begin
       len := Sendmessage(AHandle, WM_GETTEXTLENGTH, 0, 0);
       SetLength(S, len);
       SendMessage(AHandle, WM_GETTEXT, len+1, lparam(@S[1]));
       SendMessage(AHandle, EM_SETPASSWORDCHAR, Ord(Value), 0);
       SendMessage(AHandle, WM_SETTEXT, 0, Integer(PChar(S)));
     end;
     
     // Cancel the password characters and reveal the text 
    // Password Charakter aufheben und den Text anzeigen 
    procedure CancelPasswordChar(AHandle: HWND);
     var
       S: string;
       len: Integer;
     begin
       len := SendMessage(AHandle, WM_GETTEXTLENGTH, 0, 0);
       SetLength(S, len);
       SendMessage(AHandle, WM_GETTEXT, len + 1, lParam(@S[1]));
       SendMessage(AHandle, EM_SETPASSWORDCHAR, 0, 0);
       SendMessage(AHandle, WM_SETTEXT, 0, Integer(PChar(S)));
     end;
     
     // Example: 
    procedure TForm1.Button1Click(Sender: TObject);
     var
       wnd: HWND;
     begin
       wnd := FindWindowEx(GetForeGroundWindow, 0, 'TEdit', nil);
       if wnd <> 0 then
         SetPasswordChar(wnd,'*');
     end;

