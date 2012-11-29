Как сменить картинки на TDBNavigator?
=====================================

::: {.date}
01.01.2007
:::

    procedure ChangeDBNavImage(DBnav: TDbNavigator);
    var
      i: Integer;
      tempGlyph: TBitmap;
      ExePath: string;
    begin
      ExePath := ExtractFilePath(Application.ExeName);
      tempGlyph := TBitmap.Create;
      try
        with DBNav do
        begin
          for i := 0 to ControlCount - 1 do
          begin
            if Controls[i].ClassName = 'TNavButton' then
            begin
              case TNavButton(Controls[i]).Index of
                nbFirst: tempGlyph.LoadFromFile(ExePath + 'first.bmp');
                nbPrior: tempGlyph.LoadFromFile(ExePath + 'previous.bmp');
                nbNext: tempGlyph.LoadFromFile(ExePath + 'Next.bmp');
                nbLast: tempGlyph.LoadFromFile(ExePath + 'Last.bmp');
                nbInsert: tempGlyph.LoadFromFile(ExePath + 'Insert.bmp');
                nbDelete: tempGlyph.LoadFromFile(ExePath + 'Delete.bmp');
                nbEdit: tempGlyph.LoadFromFile(ExePath + 'Edit.bmp');
                nbPost: tempGlyph.LoadFromFile(ExePath + 'Post.bmp');
                nbCancel: tempGlyph.LoadFromFile(ExePath + 'Cancel.bmp');
                nbRefresh: tempGlyph.LoadFromFile(ExePath + 'Refresh.bmp');
              end;
              TNavButton(Controls[i]).Glyph := tempGlyph;
            end;
          end;
        end;
      finally
        tempGlyph.Free;
      end;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      ChangeDBNavImage(DBNavigator1);
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
