---
Title: Как перехватить нажатия функциональных клавиш и стрелок?
Author: Arx ( http://arxoft.tora.ru )
Date: 01.01.2007
---


Как перехватить нажатия функциональных клавиш и стрелок?
========================================================

Вариант 1:

Source: <https://forum.sources.ru>

Проверяйте значение переменной key на равенство VK\_RIGHT, VK\_LEFT,
VK\_F1 и т.д. на событии KeyDown формы

    procedure TForm1.FormKeyDown(Sender: TObject; var Key: Word; Shift: TShiftState);
    begin
      if Key = VK_RIGHT then
        Form1.Caption := 'Right';
      if Key = VK_F1 then
        Form1.Caption := 'F1';
    end;


------------------------------------------------------------------------

Вариант 2:

Author: Галимарзанов Фанис 

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Обработка нажатий клавиш вверх-вниз

Почти всегда требуется обработка нажатий клавиш "вверх-вниз" для смены
фокуса ввода - мои "тетки-юзеры" боются мышей, да и сам я не любитель
комбинаций мышь-клавиатура.

    procedure TfmAbProps.edNameKeyDown(Sender: TObject; var Key: Word;
      Shift: TShiftState);
    begin
      if (Key = vk_down) and
        not (ssAlt in Shift)
        {// здесь обработка для "выпадающих" окошек типа TRxDBCalcEdit} then
      begin
        Key := 0;
        SelectNext(Sender as TWinControl, true, true);
      end
      else if Key = vk_up then
      begin
        Key := 0;
        SelectNext(Sender as TWinControl, false, true);
      end;
    end;

Для элементов редактирования типа TDbEdit, TRxDBCalcEdit or TDBDateEdit
назначим

    OnKeyDown:=edNameKeyDown 

Сложнее с типами вроде TRxDBLookupCombo. Наш прежний обработчик для них
не подходит. Я пытался изменить характер TRxDBLookupCombo - но вовремя
опомнился - есть же FormKeyDown;

    procedure TfmAbProps.FormKeyDown(Sender: TObject; var Key: Word;
      Shift: TShiftState);
    begin
      if (ActiveControl is TRxDBLookupCombo) then
      begin
        if Key = vk_down then
        begin
          if not (ssAlt in Shift) and not
            // здесь нельзя обработать нажатие при вызове "выпадающего"
            (ActiveControl as TRxDBLookupCombo).IsDropDown then
          begin // и в случае уже "выпавшего"
            Key := 0;
            selectnext(ActiveControl, true, true);
          end;
        end
        else if Key = vk_up then
        begin
          if not (ActiveControl as TRxDBLookupCombo).IsDropDown then
          begin
            Key := 0;
            selectnext(ActiveControl, false, true);
          end;
        end;
      end;
    end;



------------------------------------------------------------------------

Вариант 3:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Author: Julian (TeamB & TurboPower Software) 

    procedure WMGetDlgCode(var Msg : TMessage); message WM_GETDLGCODE;
     
    ...
     
    procedure TMyControl.WMGetDlgCode(var Msg : TMessage);
    begin
      Msg.Result := DLGC_WANTARROWS;
    end;



------------------------------------------------------------------------

Вариант 4:

Author: Robert Wittig

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Вы можете перехватывать нажатие курсорных клавиш на уровне приложения:

Создайте HandleMessages как метод формы и затем назначьте его
Application.HandleMessages.

    procedure tForm1.HandleMessages(var Msg: tMsg; var Handled: Boolean);
    begin
      if (Msg.Message = WM_KeyDown) and
        (Msg.wParam in [VK_UP, VK_DOWN, VK_LEFT, VK_RIGHT]) then
      begin
        case Msg.wParam of
          VK_UP: ShowMessage('Нажата стрелка вверх');
          VK_DOWN: ShowMessage('Нажата стрелка вниз');
          VK_LEFT: ShowMessage('Нажата стрелка влево');
          VK_RIGHT: ShowMessage('Нажата стрелка вправо');
        end;
        Handled := True;
      end;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      Application.OnMessage := HandleMessages;
    end;


