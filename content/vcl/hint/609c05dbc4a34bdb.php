<h1>Использование обработчика OnHint при наличии нескольких форм</h1>
<div class="date">01.01.2007</div>


<p>В Online Help и в Visual Component Library Reference описан пример обработчика</p>
<p>события OnHint объекта TApplication. Пример показывает, как можно использовать</p>
<p>панель для отображения подсказок (hint), связанных с другими компонентами. В</p>
<p>примере обработчик OnHint устанавливается во время обработки события OnCreate</p>
<p>для формы; в программе, включающей более чем одну форму, будет трудно</p>
<p>использовать эту технику.</p>

<p>Перемещение присваивания обработчика OnHint из события OnCreate формы в</p>
<p>событие OnActivate позволит различным формам данного приложения работать с</p>
<p>подсказками, как им нужно.</p>

<p>Ниже приведен измененный пример из OnLine Help и VCL Reference.</p>
<pre>
type
  TForm1 = class(TForm)
    Button1: TButton;
    Panel1: TPanel;
    Edit1: TEdit;
    procedure FormActivate(Sender: TObject);
  private
    { Private declarations }
  public
    procedure DisplayHint(Sender: TObject);
  end;
 
implementation
 
{$R *.DFM}
 
procedure TForm1.DisplayHint(Sender: TObject);
begin
  Panel1.Caption := Application.Hint;
end;
 
procedure TForm1.FormActivate(Sender: TObject);
begin
  Application.OnHint := DisplayHint;
end;
</pre>


<p>Источник: <a href="https://dmitry9.nm.ru/info/" target="_blank">https://dmitry9.nm.ru/info/</a></p>
