<h1>Как осуществить ввод текста в компоненте TLabel?</h1>
<div class="date">01.01.2007</div>


<p>Многие программисты задавая такой вопрос получают на него стандартный ответ "используй edit box." На самом же деле этот вопрос вполне решаем, хотя лейблы и не основаны на окне и, соответственно не могут получать фокус ввода и, соответственно не могут получать символы, вводимые с клавиатуры. Давайте рассмотрим шаги, которые были предприняты мной для разработки данного компонента.</p>

<p>Первый шаг, это кнопка, которая может отображать вводимый текст:</p>
<pre>
type
  TInputButton = class(TButton)
  private
    procedure WmChar (var Msg: TWMChar);
      message wm_Char;
  end;
 
procedure TInputButton.WmChar (var Msg: TWMChar);
var
  Temp: String;
begin
  if Char (Msg.CharCode) = #8 then
  begin
    Temp := Caption;
    Delete (Temp, Length (Temp), 1);
    Caption := Temp;
  end
  else
    Caption := Caption + Char (Msg.CharCode);
end;
</pre>


<p>С меткой (label) дела обстоят немного сложнее, так как прийдётся создать некоторые ухищрения, чтобы обойти её внутреннюю структуру. Впринципе, проблему можно решить созданием других скрытых компонент (кстати, тот же edit box). Итак, посмотрим на объявление класса:</p>
<pre>
type
  TInputLabel = class (TLabel)
  private
    MyEdit: TEdit;
    procedure WMLButtonDown (var Msg: TMessage);
      message wm_LButtonDown;
  protected
    procedure EditChange (Sender: TObject);
    procedure EditExit (Sender: TObject);
  public
    constructor Create (AOwner: TComponent); override;
  end;
</pre>


<p>Когда метка (label) создана, то она в свою очередь создаёт edit box и устанавливает несколько обработчиков событий для него. Фактически, если пользователь кликает по метке, то фокус перемещается на (невидимый) edit box, и мы используем его события для обновления метки. Обратите внимание на ту часть кода, которая подражает фокусу для метки (рисует прямоугольничек), основанная на API функции DrawFocusRect:</p>
<pre>
constructor TInputLabel.Create (AOwner: TComponent);
begin
  inherited Create (AOwner);
 
  MyEdit := TEdit.Create (AOwner);
  MyEdit.Parent := AOwner as TForm;
  MyEdit.Width := 0;
  MyEdit.Height := 0;
  MyEdit.TabStop := False;
  MyEdit.OnChange := EditChange;
  MyEdit.OnExit := EditExit;
end;
 
procedure TInputLabel.WMLButtonDown (var Msg: TMessage);
begin
  MyEdit.SetFocus;
  MyEdit.Text := Caption;
  (Owner as TForm).Canvas.DrawFocusRect (BoundsRect);
end;
 
procedure TInputLabel.EditChange (Sender: TObject);
begin
  Caption := MyEdit.Text;
  Invalidate;
  Update;
  (Owner as TForm).Canvas.DrawFocusRect (BoundsRect);
end;
 
procedure TInputLabel.EditExit (Sender: TObject);
begin
  (Owner as TForm).Invalidate;
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

