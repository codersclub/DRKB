---
Title: Сохранение свойств шрифтов
Date: 01.01.2007
---

Сохранение свойств шрифтов
==========================

Вариант 1:

©Drkb::01947

    //Saving and restoring font properties in the registry
    Uses typInfo, Registry;
    Function GetFontProp( anObj: TObject) : TFont;
    Var
      PInfo: PPropInfo;
    Begin
      { try to get a pointer to the property information for a property with the
        name 'Font'. TObject.ClassInfo returns a pointer to the RTTI table,
    which
        we need to pass to GetPropInfo }
      PInfo := GetPropInfo( anObj.ClassInfo, 'font' );
      Result := Nil;
      If PInfo <> Nil Then
        { found a property with this name, check if it has the correct type }
        If (PInfo^.Proptype^.Kind = tkClass) and
           GetTypeData(PInfo^.Proptype^)^.ClassType.InheritsFrom(TFont)
        Then
          Result := TFont(GetOrdProp( anObj, PInfo ));
    End; { GetfontProp }
    Function StyleToString( styles: TFontStyles ): String;
    var
      style: TFontStyle;
    Begin
      Result := '[';
      For style := Low(style) To High(style) Do Begin
        If style IN styles Then Begin
          If Length(result) > 1 Then
            result := result + ',';
          result := result + GetEnumname( typeInfo(TFontStyle), Ord(style));
        End; { If }
      End; { For }
      Result := Result + ']';
    End; { StyleToString }
    Function StringToStyle( S: String ): TFontStyles;
    Var
      sl   : TStringlist;
      style: TfontStyle;
      i    : Integer;
    Begin
      Result := [];
      If Length(S) < 2 Then Exit;
      If S[1] = '[' Then
        Delete(S, 1, 1);
      If S[Length(S)] = ']' Then
        Delete(S, Length(S), 1);
      If Length(S) = 0 Then Exit;
      sl:= TStringlist.Create;
      try
        sl.commatext := S;
        For i := 0 To sl.Count-1 Do Begin
          try
            style := TFontStyle( GetEnumValue( Typeinfo(TFontStyle), sl[i] ));
            Include( Result, style );
          except
          end;
        End; { For }
      finally
        sl.free
      end;
    End; { StringToStyle }
    Procedure SaveFontProperties( forControl: TControl;
                                  toIni: TRegInifile;
                                  const section: String );
    Var
      font: TFont;
      basename: String;
    Begin
      Assert( Assigned( toIni ));
      font := GetFontProp( forControl );
      If not Assigned( font ) Then Exit;
      basename := forControl.Name+'.Font.';
      toIni.WriteInteger( Section, basename+'Charset', font.charset );
      toIni.WriteString ( Section, basename+'Name', font.Name );
      toIni.WriteInteger( Section, basename+'Size', font.size );
      toIni.WriteString ( Section, basename+'Color',
                          '$'+IntToHex(font.color,8));
      toIni.WriteString ( Section, basename+'Style',
                          StyleToString( font.Style ));
    End; { SaveFontProperties }
    Procedure RestoreFontProperties( forControl: TControl;
                                 toIni: TRegInifile;
                                 const section: String );
    Var
      font: TFont;
      basename: String;
    Begin
      Assert( Assigned( toIni ));
      font := GetFontProp( forControl );
      If not Assigned( font ) Then Exit;
      basename := forControl.Name+'.Font.';
      font.Charset :=
        toIni.ReadInteger( Section, basename+'Charset', font.charset );
      font.Name :=
        toIni.ReadString ( Section, basename+'Name', font.Name );
      font.Size :=
        toIni.ReadInteger( Section, basename+'Size', font.size );
      font.Color := TColor( StrToInt(
        toIni.ReadString ( Section, basename+'Color',
                          '$'+IntToHex(font.color,8))
                          ));
      font.Style := StringToStyle(
        toIni.ReadString ( Section, basename+'Style',
                           StyleToString( font.Style ))
                          );
    End; { RestoreFontProperties }

It is also possible to wrap a font into a small component and stream it:

    type
      TFontWrapper= class( TComponent )
      private
        FFont: TFont;
        Constructor Create( aOwner: TComponent ); override;
        Destructor Destroy; override;
        Procedure SetFont( value: TFont );
      published
        property Font: TFont read FFont write SetFont;
      end;
    { TFontWrapper }
    constructor TFontWrapper.Create(aOwner: TComponent);
    begin
      inherited;
      FFont :=TFont.Create;
    end;
    destructor TFontWrapper.Destroy;
    begin
      FFOnt.Free;
      inherited;
    end;
    procedure TFontWrapper.SetFont(value: TFont);
    begin
      FFont.Assign( value );
    end;
    procedure TForm1.Button1Click(Sender: TObject);
    var
      helper: TFontWrapper;
    begin
      If not Assigned(ms) then
        ms:= TMemoryStream.Create
      Else
        ms.Clear;
      helper := TFontWrapper.Create( nil );
      try
        helper.font := label1.font;
        ms.WriteComponent( helper );
      finally
        helper.free;
      end; { finally }
      label1.font.size := label1.font.size + 2;
    end;
    procedure TForm1.Button2Click(Sender: TObject);
    var
      helper: TFontWrapper;
    begin
      If not Assigned(ms) then Exit;
      ms.Position := 0;
      helper := TFontWrapper.Create( nil );
      try
        ms.ReadComponent( helper );
        label1.font := helper.font;
      finally
        helper.free;
      end; { finally }
    end;


------------------------------------------------------------------------

Вариант 2:

Source: <https://delphiworld.narod.ru>

    function FontToStr(font: TFont): string;
      procedure yes(var str: string);
      begin
     
        str := str + 'y';
      end;
      procedure no(var str: string);
      begin
     
        str := str + 'n';
      end;
    begin
     
      {кодируем все атрибуты TFont в строку}
      Result := '';
      Result := Result + IntToStr(font.Color) + '|';
      Result := Result + IntToStr(font.Height) + '|';
      Result := Result + font.Name + '|';
      Result := Result + IntToStr(Ord(font.Pitch)) + '|';
      Result := Result + IntToStr(font.PixelsPerInch) + '|';
      Result := Result + IntToStr(font.size) + '|';
      if fsBold in font.style then
        yes(Result)
      else
        no(Result);
      if fsItalic in font.style then
        yes(Result)
      else
        no(Result);
      if fsUnderline in font.style then
        yes(Result)
      else
        no(Result);
      if fsStrikeout in font.style then
        yes(Result)
      else
        no(Result);
    end;
     
    procedure StrToFont(str: string; font: TFont);
    begin
     
      if str = '' then
        Exit;
      font.Color := StrToInt(tok('|', str));
      font.Height := StrToInt(tok('|', str));
      font.Name := tok('|', str);
      font.Pitch := TFontPitch(StrToInt(tok('|', str)));
      font.PixelsPerInch := StrToInt(tok('|', str));
      font.Size := StrToInt(tok('|', str));
      font.Style := [];
      if str[0] = 'y' then
        font.Style := font.Style + [fsBold];
      if str[1] = 'y' then
        font.Style := font.Style + [fsItalic];
      if str[2] = 'y' then
        font.Style := font.Style + [fsUnderline];
      if str[3] = 'y' then
        font.Style := font.Style + [fsStrikeout];
    end;
     
    function tok(sep: string; var s: string): string;
     
      function isoneof(c, s: string): Boolean;
      var
        iTmp: integer;
      begin
        Result := False;
        for iTmp := 1 to Length(s) do
        begin
          if c = Copy(s, iTmp, 1) then
          begin
            Result := True;
            Exit;
          end;
        end;
      end;
    
    var
      c, t: string;
    
    begin
      if s = '' then
      begin
        Result := s;
        Exit;
      end;
      c := Copy(s, 1, 1);
      while isoneof(c, sep) do
      begin
        s := Copy(s, 2, Length(s) - 1);
        c := Copy(s, 1, 1);
      end;
      t := '';
      while (not isoneof(c, sep)) and (s <> '') do
      begin
        t := t + c;
        s := Copy(s, 2, length(s) - 1);
        c := Copy(s, 1, 1);
      end;
      Result := t;
    end;


------------------------------------------------------------------------

Вариант 3:

Нужно сохранять атрибуты шрифта (имя, размер и т.п.) а не сам обьект
TFont. После считывания этой информации следует проверить существует ли
такой шрифт, прежде чем его использовать. Чтобы не показаться
голословным дополню ответ Borland\'а своим примером сохранения/чтения
шрифта в/из реестра

    uses...Registry;
     
    procedure SaveFontToRegistry(Font: TFont; SubKey: string);
    var
      R: TRegistry;
      FontStyleInt: byte;
      FS: TFontStyles;
    begin
      R := TRegistry.Create;
      try
        FS := Font.Style;
        Move(FS, FontStyleInt, 1);
        R.OpenKey(SubKey, True);
        R.WriteString('Font Name', Font.Name);
        R.WriteInteger('Color', Font.Color);
        R.WriteInteger('CharSet', Font.Charset);
        R.WriteInteger('Size', Font.Size);
        R.WriteInteger('Style', FontStyleInt);
      finally
        R.Free;
      end;
    end;
     
    function ReadFontFromRegistry(Font: TFont; SubKey: string): boolean;
    var
      R: TRegistry;
      FontStyleInt: byte;
      FS: TFontStyles;
    begin
      R := TRegistry.Create;
      try
        result := R.OpenKey(SubKey, false); if not result then exit;
        Font.Name := R.ReadString('Font Name');
        Font.Color := R.ReadInteger('Color');
        Font.Charset := R.ReadInteger('CharSet');
        Font.Size := R.ReadInteger('Size');
        FontStyleInt := R.ReadInteger('Style');
        Move(FontStyleInt, FS, 1);
        Font.Style := FS;
      finally
        R.Free;
      end;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      if FontDialog1.Execute then
        begin
          SaveFontToRegistry(FontDialog1.Font, 'Delphi Kingdom\Fonts');
        end;
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    var
      NFont: TFont;
    begin
      NFont := TFont.Create;
      if ReadFontFromRegistry(NFont, 'Delphi Kingdom\Fonts') then
        begin //здесь добавить проверку - существует ли шрифт
          Label1.Font.Assign(NFont);
          NFont.Free;
        end;
    end;
