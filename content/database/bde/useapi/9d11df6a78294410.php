<h1>Обратные вызовы BDE32 для получения статуса операций</h1>
<div class="date">01.01.2007</div>


<p>Дополнительная документация, описывающая вызовы функций BDE, находится в файле BDE32.HLP (расположенном в каталоге, где установлен 32-битный IDAPI).</p>

<p>При создании функций обратного вызова BDE, BDE будет осуществлять "обратный вызов" функций вашего приложения, позволяя тем самым извещать ваше приложение о происходящих событиях, а в некоторых случаях передавать информацию обратно BDE.</p>

<p>BDE определяет несколько возвращаемых типов, которые могут быть установлены для обратного вызова:           состояние больших пакетных операций.</p>
<p>           запросы для передачи информации вызывающему оператору.</p>
<p>Данный совет подробно описывает обратный вызов типа cbGENPROGRESS, позволяющий изменять полоску прогресса в соответствии с состоянием операции.</p>

<p>Чтобы это сделать, необходимо сперва вызвать функцию DbiGetCallBack(), возвращающую дескриптор обратного вызова, который мог быть уже установлен (с этими параметрами), и сохранить информацию в структуре данных. Затем установить свой обратный вызов, заменяя им любой установленный до этого.</p>

<p>При установке вашего обратного вызова вам понадобится передавать BDE указатель на структуру данных, содержащую информацию о предыдущем установленном обратном вызове, после чего, при выполнении вашей функции обратного вызова, вы можете воспользоваться оригинальным обратным вызовом (если он установлен).</p>

<p>BDE каждый раз возвращает вашему приложению сообщение, содержащее количество обработанных записей, или же процентное соотношение обработанных записей, также передаваемое в виде целого числа. Ваш код должен учитывать эту ситуацию. Если процентное поле в структуре обратного вызова больше чем -1, можно сделать вывод что передан процент и можно сразу обновить линейку прогресса. Если же это поле меньше нуля, обратный вызов получил текстовое сообщение, помещенное в поле szTMsg и содержащее количество обработанных записей. В этом случае вам понадобится осуществить грамматический разбор текстового сообщения, преобразовать остальные строки в целое, затем вычислить текущий процент обработанных записей, и только после этого изменить линейку прогресса.</p>

<p>Наконец, после осуществления операции с данными, вам необходимо "отрегистрировать" ваш обратный вызов, и вновь установить предыдущую функцию обратного вызова (если она существует).</p>

<p>Для следующего примера необходимо создать форму и расположить на ней две таблицы, компонент ProgressBar и кнопку.</p>
<pre>
unit Testbc1;
 
interface
 
uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls,
  Forms, Dialogs, StdCtrls, Grids, DBGrids, DB, DBTables, ComCtrls;
 
type
  TForm1 = class(TForm)
    Table1: TTable;
    BatchMove1: TBatchMove;
    Table2: TTable;
    Button1: TButton;
    ProgressBar1: TProgressBar;
    procedure Button1Click(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;
 
var
  Form1: TForm1;
 
implementation
 
uses Bde; {Здесь расположены Dbi Types и Procs}
 
{$R *.DFM}
 
{тип структуры данных для сохранения информации о предыдущем обратном вызове}
type
  TDbiCbInfo = record
    ecbType: CBType;
    iClientData: longint;
    DataBuffLn: word;
    DataBuff: pCBPROGRESSDesc;
    DbiCbFn: pointer;
  end;
type
  PDbiCbInfo = ^TDbiCbInfo;
 
  {Наша функция обратного вызова}
 
function DbiCbFn(ecbType: CBType;
  iClientData: Longint;
  CbInfo: pointer): CBRType stdcall;
var
  s: string;
begin
  {Проверяем, является ли тип обратного вызова тем, который мы ожидаем}
  if ecbType = cbGENPROGRESS then
  begin
    {если iPercentDone меньше нуля, извлекаем число}
    {обработанных записей из параметра szMsg}
    if pCBPROGRESSDesc(cbInfo).iPercentDone &lt; 0 then
    begin
      s := pCBPROGRESSDesc(cbInfo).szMsg;
      Delete(s, 1, Pos(': ', s) + 1);
      {Вычислям процент выполненного и изменяем линейку прогресса}
      Form1.ProgressBar1.Position :=
        Round((StrToInt(s) / Form1.Table1.RecordCount) * 100);
    end
    else
    begin
      {Устанавливаем линейку прогресса}
      Form1.ProgressBar1.Position :=
        pCBPROGRESSDesc(cbInfo).iPercentDone;
    end;
  end;
  {существовал ли предыдущий зарегистрированный обратный вызов?}
  {если так - осуществляем вызов и возвращаемся}
  if PDbiCbInfo(iClientData)^.DbiCbFn &lt;&gt; nil then
    DbiCbFn :=
      pfDBICallBack(PDbiCbInfo(iClientData)^.DbiCbFn)
      (ecbType,
      PDbiCbInfo(iClientData)^.iClientData,
      cbInfo)
  else
    DbiCbFn := cbrCONTINUE;
end;
 
procedure TForm1.Button1Click(Sender: TObject);
var
  CbDataBuff: CBPROGRESSDesc; {Структура DBi}
  {структура данных должна хранить информацию о предыдущем обратном вызове}
  OldDbiCbInfo: TDbiCbInfo;
begin
  {Убедимся в том, что перемещаемая таблица открыта}
  Table1.Open;
  {Убедимся в том, что таблица-приемник закрыта}
  Table2.Close;
  {получаем информацию о любом установленном обратном вызове}
  DbiGetCallBack(Table2.Handle,
    cbGENPROGRESS,
    @OldDbiCbInfo.iClientData,
    @OldDbiCbInfo.DataBuffLn,
    @OldDbiCbInfo.DataBuff,
    pfDBICallBack(OldDbiCbInfo.DbiCbFn));
  {регистрируем наш обратный вызов}
  DbiRegisterCallBack(Table2.Handle,
    cbGENPROGRESS,
    longint(@OldDbiCbInfo),
    SizeOf(cbDataBuff),
    @cbDataBuff,
    @DbiCbFn);
 
  Form1.ProgressBar1.Position := 0;
  BatchMove1.Execute;
 
  {если предыдущий обратный вызов существовал - вновь устанавливаем его,}
  {в противном случае "отрегистрируем" наш обратный вызов}
  if OldDbiCbInfo.DbiCbFn &lt;&gt; nil then
    DbiRegisterCallBack(Table2.Handle,
      cbGENPROGRESS,
      OldDbiCbInfo.iClientData,
      OldDbiCbInfo.DataBuffLn,
      OldDbiCbInfo.DataBuff,
      OldDbiCbInfo.DbiCbFn)
  else
    DbiRegisterCallBack(Table2.Handle,
      cbGENPROGRESS,
      longint(@OldDbiCbInfo),
      SizeOf(cbDataBuff),
      @cbDataBuff,
      nil);
 
  {Показываем наш успех!}
  Table2.Open;
 
end;
 
end.
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

