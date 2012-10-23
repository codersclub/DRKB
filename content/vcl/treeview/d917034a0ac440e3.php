<h1>Как связать TTreeView и TPageControl?</h1>
<div class="date">01.01.2007</div>


<p>На форме стоит TreeView, PageControl и кнопка.</p>
<p>При смене страницы - меняется текущий узел, а при смене узла меняется страница.</p>
<pre>
unit Unit1;

interface
 
uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
  StdCtrls, ComCtrls;
 
type
  TForm1 = class(TForm)
    TreeView1: TTreeView;
    Button1: TButton;
    PageControl1: TPageControl;
    procedure Button1Click(Sender: TObject);
    procedure TreeView1Change(Sender: TObject; Node: TTreeNode);
    procedure PageControl1Change(Sender: TObject);
  private
    procedure addItem(t: String);
    { Private declarations }
  public
    { Public declarations }
  end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.DFM}
 
Procedure TForm1.addItem(t:String);
  var TabSheet:TTabSheet;
      Node:TTreenode;
begin
  TabSheet:=TTabSheet.Create(Self);
  TabSheet.PageControl:=PageControl1;
  TabSheet.caption:=t;
  Node:=TreeView1.Items.Add(nil, t);
  Node.data:=TabSheet; //ассоциируем узел с страницей
  TabSheet.tag:=Integer(Node); // ассоциируем страницу с узлом
 
end;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  TreeView1.HideSelection:=false;
  addItem('Item1');
  addItem('Item2');
  addItem('Item3');
  addItem('Item4');
end;
 
procedure TForm1.TreeView1Change(Sender: TObject; Node: TTreeNode);
begin
  PageControl1.ActivePage:=TTabSheet(Node.data);// Доступ к ассоциированной странице через узел
end;
 
procedure TForm1.PageControl1Change(Sender: TObject);
begin
  TreeView1.Selected:=TTreeNode(Pointer(PageControl1.ActivePage.tag));// Доступ к ассоциированному узлу через страницу
end;
 
end.
</pre>

<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

