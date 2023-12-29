---
Title: TDBGrid.CutToClipboard
Date: 01.01.2007
---


TDBGrid.CutToClipboard
======================

::: {.date}
01.01.2007
:::

Внутри TDBGrid "зашит" защищенный (protected) элемент управления типа
TInPlaceEdit, потомок TCustomMaskEdit. Данный элемент управляется
комбинацией клавиш [Shift]+[Ins] и [Shift]+[Del]. Но для нас не
существует способа оперировать элементом, поскольку он является
защищенным членом.

Да, но вы можете сделать это обманным путем. Попробуйте так:

    procedure TForm1.Paste1Click(Sender: TObject);
    begin
      SendMessage(GetFocus, WM_PASTE, 0, 0);
    end;
     
    procedure TForm1.Copy1Click(Sender: TObject);
    begin
      SendMessage(GetFocus, WM_COPY, 0, 0);
    end;

Эти методы привязаны к вашим пунктам меню. Они посылают сообщение окну с
текущим фокусом. Если это элемент управления TInPlaceEdit, то мы
добились того, чего хотели.

Взято с <https://delphiworld.narod.ru>
