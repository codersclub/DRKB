---
Title: Как перехватить Ctrl-V в компоненте TMemo?
Date: 01.01.2007
---


Как перехватить Ctrl-V в компоненте TMemo?
==========================================

::: {.date}
01.01.2007
:::

Следующий пример демонстрирует, как перехватить комбинацию Ctrl-V в
компоненте TMemo и поместить в него свой текст вместо того, который в
буфере обмена.

Пример:

    uses ClipBrd;
     
    procedure TForm1.Memo1KeyDown(Sender: TObject; var Key: Word; Shift: TShiftState);
    begin
      if ((Key = ord('V')) and (ssCtrl in Shift)) then begin
        if Clipboard.HasFormat(CF_TEXT) then
          ClipBoard.Clear;
        Memo1.SelText := 'Delphi is RAD!';
        key := 0;
      end;
    end;

Взято из <https://forum.sources.ru>
