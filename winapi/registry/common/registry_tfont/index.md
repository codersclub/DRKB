---
Title: Сохранить объект TFont в реестре
Date: 01.01.2007
---

Сохранить объект TFont в реестре
================================

::: {.date}
01.01.2007
:::

    uses Registry;
     
    procedure SaveFontToRegistry(Font : TFont; SubKey : string);
    var
      R : TRegistry;
      FontStyleInt : byte;
      FS : TFontStyles;
    begin
      R:=TRegistry.Create;
      try
        FS:=Font.Style;
        Move(FS,FontStyleInt,1);
        R.OpenKey(SubKey,True);
        R.WriteString('Font Name',Font.name);
        R.WriteInteger('Color',Font.Color);
        R.WriteInteger('CharSet',Font.Charset);
        R.WriteInteger('Size',Font.Size);
        R.WriteInteger('Style',FontStyleInt);
      finally
        R.Free;
      end;
    end;
     
    function ReadFontFromRegistry(Font : TFont; SubKey : string) : boolean;
    var
      R : TRegistry;
      FontStyleInt : byte;
      FS : TFontStyles;
    begin
      R:=TRegistry.Create;
      try
        result:=R.OpenKey(SubKey,false);
        if not result then
          exit;
        Font.name:=R.ReadString('Font Name');
        Font.Color:=R.ReadInteger('Color');
        Font.Charset:=R.ReadInteger('CharSet');
        Font.Size:=R.ReadInteger('Size');
        FontStyleInt:=R.ReadInteger('Style');
        Move(FontStyleInt,FS,1);
        Font.Style:=FS;
      finally
        R.Free;
      end;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      if FontDialog1.Execute then
        SaveFontToRegistry(FontDialog1.Font, 'Delphi Kingdom\Fonts');
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    var
      NFont : TFont;
    begin
      NFont:=TFont.Create;
      if ReadFontFromRegistry(NFont,'Delphi Kingdom\Fonts') then
      begin
        //здесь добавить проверку - существует ли шрифт
        Label1.Font.Assign(NFont);
        NFont.Free;
      end;
    end;
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

Примечание от Vit

Вообще-то надо было бы читать свойства TFont через RTTI, а не
перечислением... ибо в этом случае во-первых если в будущих версиях
дельфи класс Tfont будет изменён или дополнен, то код всё равно будет
работать правильно, а во-вторрых такой код сохранял бы значения полей
любых классов, а не только TFont...
