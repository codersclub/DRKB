<h1>Index not found Exception</h1>
<div class="date">01.01.2007</div>


<pre>
{Q: How do I open a dBASE table without the required MDX file?
   I keep getting an "Index not found..." exception.}
 
{A: When you create a dBASE table with a production index (MDX), a
   special byte is set in the header of the DBF file.  When you
   subsequently attempt to re-open the table, the dBASE driver
   will read that special byte, and if it is set, it will also
   attempt to open the MDX file.  When the MDX file cannot be
   opened, an exception is raised.
 
   To work around this problem, you need to reset the byte (byte
   28 decimal) in the DBF file that causes the MDX dependency
   to zero.
 
   The following unit is a simple example of how to handle the
   exeption on the table open, reset the byte in the DBF file,
   and re-open the table.}
 
unit Fixit;
 
interface
 
uses
  SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics,
  Controls, Forms, Dialogs, StdCtrls, DB, DBTables, Grids, DBGrids;
 
type
  TForm1 = class(TForm)
    Table1: TTable;
    Button1: TButton;
    procedure Button1Click(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.DFM}
 
const
  TheTableDir = 'c:\temp\';
  TheTableName = 'animals.dbf';
 
procedure RemoveMDXByte(dbFile: string);
  { This procedure accepts a DBF file as a parameter.  It will patch}
  { the DBF header, so that it no longer requires the MDX file }
const
  Value: Byte = 0;
var
  F: file of byte;
begin
  AssignFile(F, dbFile);
  Reset(F);
  Seek(F, 28);
  Write(F, Value);
  CloseFile(F);
end;
 
procedure TForm1.Button1Click(Sender: TObject);
  { This procedure is called in response to a button click.  It    }
  { attempts to open a table, and, if it can't find the .MDX file, }
  { it patches the DBF file and re-execute the procedure to        }
  { re-open the table without the MDX  }
begin
  try
    { set the directory for the table }
    Table1.DatabaseName := ThheTableDir;
    { set the table name }
    Table1.TableName := TheTableName;
    { attempt to open the table }
    Table1.Open;
  except
    on E: EDBEngineError do
      { The following message indicates the MDX wasn't found: }
      if Pos('Index does not exist. File', E.Message) &gt; 0 then
      begin
        { Tell user what's going on. }
        MessageDlg('MDX file not found.Attempting to Open
          without Index.', mtWarning, [mbOK], 0);
        { remove the MDX byte from the table header }
        RemoveMDXByte(TheTableDir + TheTableName);
        { Send the button a message to make it think it was }
        { pressed again.  Doing so will cause this procedure to }
        { execute again, and the table will be opened without }
        { the MDX }
        PostMessage(Button1.Handle, cn_Command, bn_Clicked, 0);
      end;
  end;
end;
 
end.
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
