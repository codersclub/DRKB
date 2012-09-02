<h1>Как настроить табуляцию в компоненте TMemo?</h1>
<div class="date">01.01.2007</div>


<p>Пошлите в Memo сообщение EM_SETTABSTOPS</p>

<p>Взято с сайта <a href="https://blackman.wp-club.net/" target="_blank">https://blackman.wp-club.net/</a></p>
<hr />
<pre>
procedure TForm1.FormCreate(Sender: TObject);
var
  DialogUnitsX: LongInt;
  PixelsX: LongInt;
  i: integer;
  TabArray: array[0..4] of integer;
begin
  Memo1.WantTabs := true;
  DialogUnitsX := LoWord(GetDialogBaseUnits);
  PixelsX := 20;
  for i := 1 to 5 do
    begin
      TabArray[i - 1] := ((PixelsX * i) * 4) div DialogUnitsX;
    end;
  SendMessage(Memo1.Handle,
    EM_SETTABSTOPS, 5, LongInt(@TabArray));
  Memo1.Refresh;
end;
</pre>

<p>Взято из </p>
DELPHI VCL FAQ Перевод с английского &nbsp; &nbsp; &nbsp; 
<p>Подборку, перевод и адаптацию материала подготовил Aziz(JINX)</p>
<p>специально для <a href="https://delphi.vitpc.com/" target="_blank">Королевства Дельфи</a></p>


<hr />
<p>Для этого надо послать сообщение EM_SetTabStops компоненте TMemo, в котором необходимо указать два параметра. Количество передаваемых значений и величины табуляций. </p>

<p>Если первый параметр равняется нулю, то второй параметр игнорируется и величина табуляции сбрасывается в значение по умолчанию (32). Иначе, устанавливается величина указанная во втором параметре, причем, при единичном значении все величины табуляций будут равны, а при большем значении величины берутся из переданного массива. </p>

<pre>
{Установка одной величины табуляции}
const
  TabInc: LongInt = 40;
 
begin
  SendMessage(Memo1.Handle, EM_SetTabStops, 1, Longint(@TabInc));
end;
 
...
 
{Установка двух величин табуляции}
const
  TabInc: array [1..2] of LongInt = (10, 30);
 
begin
  SendMessage(Memo1.Handle, EM_SetTabStops, 2, Longint(@TabInc));
end;
 
 
</pre>
<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

