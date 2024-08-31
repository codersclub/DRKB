---
Title: Как заставить кнопку Enter работать наподобие Tab?
Author: Khaled Shagrouni
Date: 01.01.2007
---


Как заставить кнопку Enter работать наподобие Tab?
==================================================

Вариант 1:

Source: <https://forum.sources.ru>

Как-то бухгалтер, который пользовался моей программой, заявил, что ему
не удобно перескакивать пустые поля в форме кнопкой Tab, и что намного
удобнее это делать обычным Enter-ом. Предлагаю посмотреть, как я решил
эту проблемму.

Совместимость: Все версии Delphi

Пример обработчика события:

    procedure Tform1.FormKeyDown(Sender: TObject; var Key: Word; 
      Shift: TShiftState); 
    var 
      ACtrl: TWinControl; 
    begin 
      if key = 13 then 
        begin 
          ACtrl := ActiveControl; 
          if ACtrl is TCustomMemo then exit; 
          repeat 
            ACtrl:= FindNextControl(ACtrl,true,true,false); 
          until (ACtrl is TCustomEdit) or 
          (ACtrl is TCustomComboBox) or 
          (ACtrl is TCustomListBox) or 
          (ACtrl is TCustomCheckBox) or 
          (ACtrl is TRadioButton); 
          ACtrl.SetFocus ; 
        end; 
    end; 

Не забудьте установить свойство формы KeyPreview в true.

Как Вы можете видеть, этот код использует функцию FindNextControl,
которая ищет следующий свободный контрол.

Так как все формы в моём приложении наследуются от одной, то достаточно
поместить этот код в главную форму и после этого все формы будут
реагировать на нажатие Enter подобным образом.


------------------------------------------------------------------------

Вариант 2:

Source: <https://forum.sources.ru>

Существует множество методов решения этой проблемы, но самый быстрый
способ, это перехват нажатия клавиш, перед тем как их получит форма:

В секции формы PRIVATE добавьте:

    Procedure CMDialogKey(Var Msg:TWMKey); message CM_DIALOGKEY; 

В секции IMPLEMENTATION добавьте:

    Procedure TForm1.CMDialogKey(Var Msg: TWMKey); 
    Begin 
    If NOT (ActiveControl Is TButton) Then 
    If Msg.Charcode = 13 Then 
    Msg.Charcode := 9; 
    inherited; 
    End;

Тем самым мы исключаем срабатывания нашей подмены, если фокус находится
на кнопке.

Чтобы ускорить работу приложения, не надо активизировать свойство формы
KEYPREVIEW

------------------------------------------------------------------------

Вариант 3:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    procedure TForm1.FormCreate(Sender: TObject);
    begin
      Form1.KeyPreview := true;
    end;
     
    procedure TForm1.FormKeyDown(Sender: TObject; var Key: Word;
      Shift: TShiftState);
    var
      c: TControl;
    begin
      if Key <> 13 then
        Exit;
      repeat
        c := Form1.FindNextControl(Form1.ActiveControl, true, true, true);
        (c as TWinControl).SetFocus;
      until
        c is TEdit;
    end;


------------------------------------------------------------------------

Вариант 4:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    procedure TForm1.Edit1KeyPress(Sender: TObject; var Key: Char);
    begin
      if Key = Chr(VK_RETURN) then
      begin
        Perform(WM_NEXTDLGCTL,0,0);
        key:= #0;
      end;
    end;


------------------------------------------------------------------------

Вариант 5:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    procedure TForm1.FormKeyPress(Sender: TObject; var Key: Char);
    begin
     if Key = #13 then
     begin
       SelectNext(Sender as TWinControl, True, True);
       Key := #0;
     end;
    end;


------------------------------------------------------------------------

Вариант 6:

Source: <https://www.swissdelphicenter.ch>

    { 
      This code gives the  key the same habbit as the key to 
      change focus between Controls. 
    }
     
    // Form1.KeyPreview := True ! 
     
    procedure TForm1.FormKeyPress(Sender: TObject; var Key: Char);
    begin
      if Key = #13 then
      begin
        Key := #0;
        { check if SHIFT - Key is pressed }
        if GetKeyState(VK_Shift) and $8000 <> 0 then
          PostMessage(Handle, WM_NEXTDLGCTL, 1, 0)
        else
          PostMessage(Handle, WM_NEXTDLGCTL, 0, 0);
      end;
    end;

