---
Title: Как выводить hint при движении мыши над списком
Author: Даниил Карапетян (delphi4all@narod.ru)
Date: 01.01.2007
---


Как выводить hint при движении мыши над списком
===============================================

В Windows, в частности в Delphi, используются Hint для полного
отображения не умещающихся строк. Достаточно к такой строке поднести
мышь, и всплывает подсказка с полным текстом на том же месте. Как это
реализовать показано ниже.

    ...
    public
      HintRow: Integer;
      HintString: String;
      procedure OnShowHint(var HintStr: string;
        var CanShow: Boolean; var HintInfo: THintInfo);
    ...
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      Application.HintPause := 100;
      Application.HintHidePause := 30000;
     
      ListBox1.Items.Add('It is a long row');
      ListBox1.Items.Add('It is a very long row');
      ListBox1.Items.Add('And it is a very very long row');
     
      ListBox1.Items.Add('But this row if longer then other rows');
      ListBox1.Items.Add('It was not truth, because this row is so long, that I do not know, what' + #13#10 +
        'will do the program with this row. Do You know it? I think that it will be' + #13#10 +
        'very interesting to look at this row. But if it will be longer and longer,' + #13#10 +
        'what will be? Look!!!');
      ListBox1.Items.Add('Short row');
      ListBox1.Items.Add('123');
     
      HintRow := -1;
      Application.OnShowHint := OnShowHint;
     
      ListBox1.ShowHint := true;
    end;
     
    procedure TForm1.ListBox1MouseMove(Sender: TObject; Shift: TShiftState; X, Y: Integer);
    var
      ItemNum: Integer;
    begin
      ItemNum := ListBox1.ItemAtPos(Point(X, Y), True);
      if (ItemNum <> HintRow) then begin
        HintRow := ItemNum;
        Application.CancelHint;
        if HintRow > -1 then begin
          HintString := ListBox1.Items[ItemNum];
          if (ListBox1.Canvas.TextWidth(HintString) <= ListBox1.ClientWidth)
     
            then HintString := '';
        end else HintString := '';
      end;
    end;
     
    procedure TForm1.OnShowHint(var HintStr: string;
      var CanShow: Boolean; var HintInfo: THintInfo);
    begin
      if not (HintInfo.HintControl is TListBox) then Exit;
      with HintInfo.HintControl as TListBox do begin
        HintInfo.HintPos := ListBox1.ClientToScreen(Point(-1,
     
          ListBox1.ItemRect(HintRow).Top - 3));
        HintStr := HintString;
      end;
    end;


Автор справки: Алексей Денисов (aleksey@sch103.krasnoyarsk.su)
