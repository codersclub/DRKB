<h1>Как работать с адресной книгой Lotus Notes?</h1>
<div class="date">01.01.2007</div>


<pre class="delphi">
unit Unit2;
 
interface
 
uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, Domino_TLB, Menus, ComCtrls;
const
  PASSWD = 'ur70';
type
  TForm2 = class(TForm)
    TV_INFO: TTreeView;
    MainMenu1: TMainMenu;
    File1: TMenuItem;
    Create1: TMenuItem;
    Init1: TMenuItem;
    AddressBook1: TMenuItem;
    Scan1: TMenuItem;
    procedure Create1Click(Sender: TObject);
    procedure Init1Click(Sender: TObject);
    procedure Scan1Click(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;
 
var
  Form2: TForm2;
  Session: TNotesSession;
implementation
 
{$R *.dfm}
 
procedure TForm2.Create1Click(Sender: TObject);
begin
  Session := TNotesSession.Create(nil);
end;
 
procedure TForm2.Init1Click(Sender: TObject);
begin
  Session.Initialize(PASSWD);
end;
 
procedure TForm2.Scan1Click(Sender: TObject);
var
  NotesDb: NotesDatabase;
  addrBook: NotesDatabase;
  People, People2: NotesView;
  Person, Person2: NotesDocument;
  View: NotesView;
  Item: NotesItem;
  AddrBooks: OleVariant;
  Views: OleVariant;
  Items: OleVariant;
  x, y, z: integer;
  view_name: string;
  tn, tc: TTreeNode;
begin
  NotesDb := Session.GetDatabase('', 'names.nsf', False);
  AddrBooks := Session.AddressBooks;
  for x := 0 to VarArrayHighBound(AddrBooks, 1) -
    VarArrayLowBound(AddrBooks, 1) do
  begin
    addrBook := NotesDatabase(IUnknown(AddrBooks[x]));
    if (addrBook.IsPrivateAddressBook) then
    begin
      addrBook.Open;
    end
    else
      addrBook := nil;
    if (addrBook &lt;&gt; nil) then
    begin
      Views := addrBook.Views;
      for y := 0 to VarArrayHighBound(Views, 1) -
        VarArrayLowBound(Views, 1) do
      begin
        View := NotesView(IUnknown(Views[y]));
        view_name := View.Name;
        tn := tv_info.Items.AddNode(nil, nil, view_name, nil, naAdd);
 
        if copy(view_name, 1, 1) = '$' then
          view_name := copy(view_name, 2, length(view_name) - 1);
        people := addrBook.GetView(view_name);
        person := people.GetFirstDocument;
        if Person &lt;&gt; nil then
        begin
          Items := Person.Items;
          for z := 0 to VarArrayHighBound(Items, 1) -
            VarArrayLowBound(Items, 1) do
          begin
            Item := NotesItem(IUnknown(Items[z]));
            tc := tv_info.Items.AddChild(tn, Item.Name);
 
            people := addrBook.GetView(view_name);
            person := people.GetFirstDocument;
 
            while (Person &lt;&gt; nil) do
            begin
              try
                try
                  tv_info.Items.AddChild(tc, Person.GetFirstItem(Item.Name).Text
                    {Item.Text});
                except
                end;
              finally
                Person := People.GetNextDocument(Person);
              end;
            end;
          end;
        end;
      end;
 
    end;
  end;
end;
 
end.
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
