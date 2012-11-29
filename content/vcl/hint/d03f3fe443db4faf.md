Как создать собственное Hint-окно
=================================

::: {.date}
01.01.2007
:::

Автор: Олег Кулабухов

    procedure TForm1.FormCreate(Sender: TObject);
    begin
      Timer1.Enabled := false;
      Panel1.Visible := false;
      Panel1.BevelInner := bvNone;
      Panel1.BevelOuter := bvNone;
      Panel1.BorderStyle := bsSingle;
      Panel1.Color := clWhite;
      Button1.Hint := 'Hint test';
    end;
     
    procedure TForm1.ShowAHint(x: integer;
      y: integer;
      Caption: string;
      Duration: LongInt);
    var
      dc: hdc;
      OldFont: hFont;
      pt: TSize;
      p: pChar;
    begin
      if Timer1.Enabled <> false then
        Timer1.Enabled := false;
      Timer1.Enabled := false;
      if Panel1.Visible <> false then
        Panel1.Visible := false;
      if Caption = '' then
        exit;
      Panel1.Caption := caption;
      {Get the width of the caption string}
      GetMem(p, Length(Panel1.Caption) + 1);
      StrPCopy(p, Panel1.Caption);
      dc := GetDc(Panel1.Handle);
      OldFont := SelectObject(dc, Panel1.Font.Handle);
      GetTextExtentPoint32(dc, p, Length(Panel1.Caption), pt);
      SelectObject(dc, OldFont);
      ReleaseDc(Panel1.Handle, Dc);
      FreeMem(p, Length(Panel1.Caption) + 1);
      {Position and show the panel}
      Panel1.Left := x;
      Panel1.Top := y;
      Panel1.Width := pt.cx + 6;
      Panel1.Height := pt.cy + 2;
      Panel1.Visible := true;
      {Fire off the timer to hide the panel}
      Timer1.Interval := Duration;
      Timer1.Enabled := true;
    end;
     
    procedure TForm1.Timer1Timer(Sender: TObject);
    begin
      if Panel1.Visible <> false then
        Panel1.Visible := false;
      Timer1.Enabled := false;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      {Let the button repaint}
      Application.ProcessMessages;
      ShowAHint(Button1.Left,
        Button1.Top + Button1.Height + 6,
        Button1.Hint,
        2000);
    end; 

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
