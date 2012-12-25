---
Title: Как перехватить сообщения скроллирования в TScrollBox?
Date: 01.01.2007
---


Как перехватить сообщения скроллирования в TScrollBox?
======================================================

::: {.date}
01.01.2007
:::

Следующий пример перхватывает сообщения скроллирования в компоненте
TScrollBox, тем самым синхронизируя два скролбара. Если один из
скролбаров изменяет своё положение, то значение второго скролбара
изменяется на такую же величину. Сообщения скролирования перехватываются
путём сабклассинга оконной процедуры (WinProc) у скролбара.

Пример:

    type
    {$IFDEF WIN32}
      WParameter = LongInt;
    {$ELSE}
      WParameter = Word;
    {$ENDIF}
      LParameter = LongInt;
     
    {Объявляем переменную для хранения подменённой оконной процедуры}
    var
      OldWindowProc : Pointer;
     
    function NewWindowProc(WindowHandle : hWnd;
                           TheMessage   : WParameter;
                           ParamW       : WParameter;
                           ParamL       : LParameter) : LongInt
    {$IFDEF WIN32} stdcall; {$ELSE} ; export; {$ENDIF}
    var
      TheRangeMin : integer;
      TheRangeMax : integer;
      TheRange : integer;
    begin
     
      if TheMessage = WM_VSCROLL then begin
      {Получаем минимальное и максимальное значения scroll box}
        GetScrollRange(WindowHandle,
                       SB_HORZ,
                       TheRangeMin,
                       TheRangeMax);
      {Получаем вертикальную позицию scroll box}
        TheRange := GetScrollPos(WindowHandle,
                                 SB_VERT);
      {Проверим, чтобы не выйти за диапазон}
        if TheRange < TheRangeMin then
          TheRange := TheRangeMin else
        if TheRange > TheRangeMax then
          TheRange := TheRangeMax;
      {Устанавливаем горизонтальный scroll bar}
        SetScrollPos(WindowHandle,
                     SB_HORZ,
                     TheRange,
                     true);
      end;
     
      if TheMessage = WM_HSCROLL then begin
      {Получаем мин. и макс. диапазон горизонтального scroll box}
        GetScrollRange(WindowHandle,
                       SB_VERT,
                       TheRangeMin,
                       TheRangeMax);
      {Получаем позицию горизонтального scroll box}
        TheRange := GetScrollPos(WindowHandle,
                                 SB_HORZ);
      {Проверим, чтобы не выйти за диапазон}
        if TheRange < TheRangeMin then
          TheRange := TheRangeMin else
        if TheRange > TheRangeMax then
          TheRange := TheRangeMax;
      {Устанавливаем вертикальный scroll bar}
        SetScrollPos(WindowHandle,
                     SB_VERT,
                     TheRange,
                     true);
      end;
     
    { Вызываем старую оконную процедуру }
    { чтобы обработались сообщения. }
      NewWindowProc := CallWindowProc(OldWindowProc,
                                      WindowHandle,
                                      TheMessage,
                                      ParamW,
                                      ParamL);
    end;
     
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
    { Устанавливаем новую оконную процедуру для контрола }
    { и запоминаем старую оконную процедуру.    }
      OldWindowProc := Pointer(SetWindowLong(ScrollBox1.Handle,
                                             GWL_WNDPROC,
                                             LongInt(@NewWindowProc)));
    end;
     
    procedure TForm1.FormDestroy(Sender: TObject);
    begin
    { Возвращаем обратно старую оконную процедуру.  }
      SetWindowLong(ScrollBox1.Handle,
                    GWL_WNDPROC,
                    LongInt(OldWindowProc));
     
    end;

Взято из <https://forum.sources.ru>
