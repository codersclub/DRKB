<h1>Прямой вызов Hint</h1>
<div class="date">01.01.2007</div>


<pre>
function RevealHint(Control: TControl): THintWindow;
{----------------------------------------------------------------}
{ Демонстрирует всплывающую подсказку для определенного элемента }
{ управления (Control), возвращает ссылку на hint-объект,        }
{ поэтому в дальнейшем подсказка может быть спрятана вызовом     }
{ RemoveHint (смотри ниже).                                      }
{----------------------------------------------------------------}
 
var
  ShortHint: string;
  AShortHint: array[0..255] of Char;
  HintPos: TPoint;
  HintBox: TRect;
begin
  { Создаем окно: }
  Result := THintWindow.Create(Control);
 
  { Получаем первую часть подсказки до '|': }
  ShortHint := GetShortHint(Control.Hint);
 
  { Вычисляем месторасположение и размер окна подсказки }
  HintPos := Control.ClientOrigin;
  Inc(HintPos.Y, Control.Height + 6);
  &lt; &lt; &lt; &lt; Смотри примечание ниже
    HintBox := Bounds(0, 0, Screen.Width, 0);
  DrawText(Result.Canvas.Handle,
    StrPCopy(AShortHint, ShortHint), -1, HintBox,
    DT_CALCRECT or DT_LEFT or DT_WORDBREAK or DT_NOPREFIX);
  OffsetRect(HintBox, HintPos.X, HintPos.Y);
  Inc(HintBox.Right, 6);
  Inc(HintBox.Bottom, 2);
 
  { Теперь показываем окно: }
  Result.ActivateHint(HintBox, ShortHint);
end; {RevealHint}
 
procedure RemoveHint(var Hint: THintWindow);
{----------------------------------------------------------------}
{ Освобождаем дескриптор окна всплывающей подсказки, выведенной  }
{ предыдущим RevealHint.                                         }
{----------------------------------------------------------------}
 
begin
  Hint.ReleaseHandle;
  Hint.Free;
  Hint := nil;
end; {RemoveHint}
</pre>
<p>Строка с комментарием &lt;&lt;&lt;&lt; позиционирует подсказку ниже элемента управления. Это может быть изменено, если по какой-то причине вам необходима другая позиция окна с подсказкой.</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
<hr />
<div class="author">Автор: Nomadic</div>
<pre>
{Появление}
IF h&lt;&gt;nil H.ReleaseHandle; {если чей-то хинт yже был, то его погасить}
H:=THintWindow.Create(Окно-владелец хинта);
H.ActivateHint(H.CalcHintRect(...),'hint hint nint');
....
{UnПоявление :) - это возможно пpидется повесить на таймеp, котоpый бyдет
обнyляться пpи каждом новом появлении хинта}
IF h&lt;&gt;nil H.ReleaseHandle;
</pre>
<p>По-дpyгомy задача тоже pешаема, но очень плохо. (см исходник объекта TApplication, он как pаз сабжами заведyет.</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
<hr />
<p>Сделаем это по нажатию на первую кнопку, а по нажатию на вторую кнопку будем скрывать окно hint'a:</p>
<pre>
public
  { Public declarations }
  h: THintWindow;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  if h&lt;&gt;nil then
    H.ReleaseHandle;
  H:=THintWindow.Create(Form1);
  H.ActivateHint(Form1.ClientRect, 'Это всплывающая подсказка');
end;
 
procedure TForm1.Button2Click(Sender: TObject);
begin
  if h&lt;&gt;nil then
    H.ReleaseHandle;
end; 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

