<h1>Как перехватить нажатия функциональных клавиш и стрелок?</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Arx ( http://arxoft.tora.ru )</div>

<p>Проверяйте значение переменной key на равенство VK_RIGHT, VK_LEFT, VK_F1 и т.д. на событии KeyDown формы</p>
<pre>
procedure TForm1.FormKeyDown(Sender: TObject; var Key: Word; Shift: TShiftState);
begin
  if Key = VK_RIGHT then
    Form1.Caption := 'Right';
  if Key = VK_F1 then
    Form1.Caption := 'F1';
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

<hr />
<p>Обработка нажатий клавиш вверх-вниз</p>

<p> Автор: Галимарзанов Фанис&nbsp;</p>

<p>Почти всегда требуется обработка нажатий клавиш "вверх-вниз" для смены фокуса ввода - мои "тетки-юзеры" боются мышей, да и сам я не любитель комбинаций мышь-клавиатура.</p>

<pre>
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
</pre>

<p>Для элементов редактирования типа TDbEdit, TRxDBCalcEdit or TDBDateEdit назначим</p>

<pre>
OnKeyDown:=edNameKeyDown 
</pre>


<p>Сложнее с типами вроде TRxDBLookupCombo. Наш прежний обработчик для них не подходит. Я пытался изменить характер TRxDBLookupCombo - но вовремя опомнился - есть же FormKeyDown;</p>

<pre>
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
      begin // и в случае уже "выпвшего"
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
</pre>

<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

<hr />
<pre>
//Автор: Cheers, Julian (TeamB &amp; TurboPower Software) 
 
 
 
procedure WMGetDlgCode(var Msg : TMessage); message WM_GETDLGCODE;
 
...
 
procedure TMyControl.WMGetDlgCode(var Msg : TMessage);
begin
  Msg.Result := DLGC_WANTARROWS;
end;
</pre>



<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

<hr />
<div class="author">Автор: Robert Wittig </div>

<p>Вы можете перехватывать нажатие курсорных клавиш на уровне приложения:</p>

<p>Создайте HandleMessages как метод формы и затем назначьте его Application.HandleMessages.</p>

<pre>
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
</pre>



<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>


