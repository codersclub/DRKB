---
Title: Получить bitmap радио кнопок
Date: 01.01.2007
---


Получить bitmap радио кнопок
============================

    { 
      Diese Funktion liefert ein Bitmap eines RadioButton. 
     
      Parameter: 
      Checked = RadioButton ausgewahlt 
      Hot = RadioButton aktiv (funktioniert nur unter XP und 
      bewirkt z.B. unter Luna einen hellroten Rand) 
      BgColor = Hintergrundfarbe des RadioButton 
     
      Wichtig: 
      Die Bitmap sollte nach Ausfuhrung der Funktion wieder freigegeben werden! 
      XP-Styles werden erst ab Delphi7 unterstutzt. 
    }
     
    Code:{$IFDEF VER150}
    
    uses
      Themes;
    {$ENDIF}
    
    function GetRadioButtonBitmap(Checked, Hot : boolean; BgColor : TColor): TBitmap;
    const
      CtrlState : array[boolean] of integer = (DFCS_BUTTONRADIO,
        DFCS_BUTTONRADIO or DFCS_CHECKED);
    var
      CBRect : TRect;
      {$IFDEF VER150}
      Details : TThemedElementDetails;
      {$ENDIF}
      BgOld : TColor;
      ChkBmp : TBitmap;
      ThemeOK : boolean;
      x, x2, y : integer;
    begin
      Result := nil;
      try
        Result := TBitmap.Create;
        ChkBmp := TBitmap.Create;
        ThemeOK := False;
        with Result do
        begin
          Width := 16;
          Height := 16;
          with Canvas do
          begin
            Brush.Color := BgColor;
            FillRect(ClipRect);
            ChkBmp.Assign(Result);
            CBRect := ClipRect;
            CBRect.Top := 1;
            CBRect.Left := 1;
     
            {$IFDEF VER150}
            if ThemeServices.ThemesAvailable then
            begin
             //ab WinXP 
             if Checked = True then
              begin
                if Hot = True then
                  Details := ThemeServices.GetElementDetails(tbRadioButtonCheckedHot)
                else
                  Details :=
                    ThemeServices.GetElementDetails(tbRadioButtonCheckedNormal);
              end
              else
              begin
                if Hot = True then
                  Details :=
                    ThemeServices.GetElementDetails(tbRadioButtonUncheckedHot)
                else
                  Details :=
                    ThemeServices.GetElementDetails(tbRadioButtonUncheckedNormal);
              end;
              ThemeServices.DrawElement(Handle, Details, CBRect);
              //Prufen ob es tatsachlich geklappt hat (Win2003 liefert leere Images!) 
              for x := 15 downto 0 do
                for y := 15 downto 0 do
                  if ChkBmp.Canvas.Pixels[x, y] <> Pixels[x, y] then
                  begin
                    ThemeOK := True;
                    break;
                  end;
            end;
            {$ENDIF}
    
            if ThemeOK = False then
            begin
              //alles vor WinXP 
              CBRect.Left := ClipRect.Left + 2;
              CBRect.Right := ClipRect.Right - 1;
              CBRect.Top := ClipRect.Top + 2;
              CBRect.Bottom := ClipRect.Bottom - 1;
              DrawFrameControl(Handle, CBRect, DFC_BUTTON, CtrlState[Checked]);
            end;
          end;
        end;
      finally
      end;
    end;
     
