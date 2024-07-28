---
Title: Установка каретки в TRichEdit
Date: 01.01.2007
---


Установка каретки в TRichEdit
=============================

Вариант 1:

Source: <https://forum.sources.ru>

Узнать положение курсора в RichEdit не составляет труда
(richedit.getcaret). А вот как установить каретку в нужное место?

    Procedure setline(WhichEdit:TRichedit;Linepos,charpos:integer);
    Begin
    with WhichEdit do
    begin
      selstart:=perform(EM_LineIndex,Linenum,0)+charpos;
      perform(EM_ScrollCaret,0,0);
    end;
    end;

Комментарии:

Если Вам не нужно, чтобы происходил скроллинг к позиции каретки, то
EM\_ScrollCaret можно убрать. Эта процедура так же может быть
использована для TMemo, только надо будет заменить объявление witchedit
на TMemo:

    Procedure CustomMemoSetline(WhichEdit:TCustomMemo;Linepos,charpos:integer);

Также эту процедуру можно использовать как ответ на вопрос "Как
установить фокус на определённую строку в компоненте Memo ?". Для этого
необходимо добавить следующий код после строки selstart:

    sellength:=length(lines(line));

И установить charpos в 0.

RichEdit должен иметь фокус, иначе em\_ScrollCaret не сработает.


------------------------------------------------------------------------

Вариант 2:

Source: <https://www.swissdelphicenter.ch>

    // You can move the caret in a TRichEdit component by using this code : 
     
    procedure RichEdit_MoveTo(RichEdit: TRichEdit; LineNumber, CharNumber: Word);
     begin
       RichEdit.SelStart := RichEdit.Perform(EM_LINEINDEX, LineNumber, 0) + CharNumber);
     end;
     
     procedure TForm1.Button1Click(Sender: TObject);
     begin
       RichEdit_MoveTo(RichEdit1,2,5);
       Application.ProcessMessages;
       RichEdit1.SetFocus;
     end;

