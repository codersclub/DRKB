---
Title: Получение информации о TaskBar
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---

Получение информации о TaskBar
==============================

Для вывода информации мы будем использовать компонент TStringGrid с
закладки Additional.

Сначала вам нужно будет после

    var
      Form1: TForm1;

добавить следующий код:

    AppBarData : TAppBarData;
    bAlwaysOnTop, bAutoHide : boolean;
    Clrect,rect : TRect;
    Edge: UInt;

затем после слова Implementation пишем

    procedure DetectTaskBar;
    begin
      AppBarData.hWnd := FindWindow('Shell_TrayWnd', nil);
      AppBarData.cbSize := sizeof(AppBarData);
      bAlwaysOnTop := (SHAppBarMessage(ABM_GETSTATE, AppBardata)
      and ABS_ALWAYSONTOP) <> 0;
      bAutoHide := (SHAppBarMessage(ABM_GETSTATE, AppBardata)
      and ABS_AUTOHIDE) <> 0;
      GetClientRect(AppBarData.hWnd, Clrect);
      GetWindowRect(AppBarData.hwnd, rect);
      if rect.top > 0 then
        Edge := ABE_BOTTOM
      else
      if rect.bottom < screen.height then
        Edge:=ABE_TOP
      else
      if rect.right < screen.width then
        Edge:=ABE_LEFT
      else
        Edge:=ABE_RIGHT;
    end;

и осталось описать самое главное - обработчик нажатия кнопки:

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      DetectTaskBar;
     
      StringGrid1.Cells[0,0] := 'Выше других окон';
      StringGrid1.Cells[0,1] := 'Автоматически убирать с экрана';
      StringGrid1.Cells[0,2] := 'Клиентская область';
      StringGrid1.Cells[0,3] := 'Оконная область';
      StringGrid1.Cells[0,4] := 'Края';
     
      if bAlwaysOnTop = true then
        StringGrid1.Cells[1,0] := 'true'
      else
        StringGrid1.Cells[1,0] := 'false';
     
      if bAutoHide = true then
        StringGrid1.Cells[1,1] := 'true'
      else
        StringGrid1.Cells[1,1] := 'false';
     
      StringGrid1.Cells[1,2] := IntToStr(Clrect.Left)+':'+IntToStr(Clrect.Top) +
      ':'+IntToStr(Clrect.Right)+':'+IntToStr(Clrect.Bottom);
     
      StringGrid1.Cells[1,3] := IntToStr(rect.Left)+':'+IntToStr(rect.Top) +
      ':'+IntToStr(rect.Right)+':'+IntToStr(rect.Bottom);
     
      StringGrid1.Cells[1,4] := IntToStr(Edge);
    end;

