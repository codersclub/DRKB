---
Title: Как програмно прокрутить Memo?
Date: 01.01.2007
---


Как програмно прокрутить Memo?
==============================

::: {.date}
01.01.2007
:::

Этот пример прокручивает на одну строку вниз.

    memo1.Perform(WM_VScroll, SB_LINEDOWN,0);

Возможны так же следующие опции:

SB\_BOTTOM

SB\_ENDSCROLL

SB\_LINEDOWN

SB\_LINEUP

SB\_PAGEDOWN

SB\_PAGEUP

SB\_THUMBPOSITION

SB\_THUMBTRACK

SB\_TOP

TComboBox, TListBox, TRichEdit и т.п можно прокрутить подобным образом

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

В поле ввода вводите на какую строку нужно сойти, и по нажатию на кнопку
эта строка будет попадать о зону видимости:

    procedure TForm1.Button1Click(Sender: TObject);
    var
      line: integer;
    begin
      line := StrToIntDef(Edit1.Text,1);
      Memo1.SelStart := Memo1.Perform(EM_LINEINDEX, line, 0);
      Memo1.Perform(EM_SCROLLCARET, 0, 0);
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

 

------------------------------------------------------------------------

    Var
      ScrollMessage:TWMVScroll;
    begin
      ScrollMessage.Msg:=WM_VScroll;
      for i := Memo1.Lines.Count DownTo 0 do
      begin
        ScrollMessage.ScrollCode:=sb_LineUp;
        ScrollMessage.Pos:=0;
        Memo1.Dispatch(ScrollMessage);
      end;
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
