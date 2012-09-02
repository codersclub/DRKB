<h1>Как создать консольное ASP.NET приложение с событиями Delphi?</h1>
<div class="date">01.01.2007</div>


<pre>
{
****************** Below is a complete listing for an ASPX file to open and
read an ACCESS database. Obviously the source=c:\mydb.mdb declaration should
be changed to point to your own database. The sql commands will also need to
be ammended to point to the correct tables and values. This souce code is a
translation from native c#. Any problems with the code or , thanks, comments
or general abuse over codeing standrds should be sent to andychap@hotmail.com,
Please put "delphi" in the subject line so I can junk filter.

Good luck.....

As another issue I've also got some examples I've written for Delphi for Dot Net
doing similar stuff

**********************************************************************************
}

&lt;%@ Page Language="Delphi" %&gt;
&lt;%@ import Namespace="System.Data" %&gt;
&lt;%@ import Namespace="System.Data.OleDb" %&gt;
&lt;script runat="server"&gt;
  procedure Button1Click(Sender: System.Object; E: EventArgs);
    var
      MyConnection : OleDbConnection ;
      dbReader : OleDbDataReader;
      cmd : OleDbCommand;
      abc : string;
      outval : string;
      intval : longint;
  begin
    abc := 'Provider=Microsoft.Jet.OLEDB.4.0;Password=;Data Source=c:\mydb.mdb';
    MyConnection := OleDbConnection.Create(abc);
    MyConnection.Open;
    cmd := MyConnection.CreateCommand;
    cmd.CommandText := 'Select * from Table1';
    dbReader := cmd.ExecuteReader;
    while (dbReader.Read) do
      begin
        intval := dbReader.GetInt32(0);
        outval := dbReader.GetString(1);
      end;
    Label1.Text := inttostr(intval);
  end;

  procedure Button2Click(Sender: System.Object; E: EventArgs);
    var
     ConnStr : string;
     CommTxt : string;
     MyConnection : OleDbConnection ;
     abc : string;
     cmdText : string;
     cmd : OleDbCommand;

  begin
    ConnStr := 'Provider=Microsoft.Jet.OLEDB.4.0;Password=;Data Source=c:\mydb.mdb';
    CommTxt := 'select andy as [first name], chapman as [Last Name] from Table1';
    abc := 'Provider=Microsoft.Jet.OLEDB.4.0;Password=;Data Source=c:\mydb.mdb';
    MyConnection := OleDbConnection.Create(abc);
    cmd := OleDbCommand.Create(CommTxt,MyConnection);
    MyConnection.Open;
    DataGrid1.DataSource := cmd.ExecuteReader(CommandBehavior.CloseConnection);
    DataGrid1.DataBind();
  end;
&lt;/script&gt;
&lt;html&gt;
&lt;head&gt;
&lt;/head&gt;
&lt;body style="FONT-FAMILY: arial"&gt;
    &lt;h2&gt;Simple Data Report
    &lt;/h2&gt;
    &lt;hr size="1" /&gt;
    &lt;form runat="server"&gt;
        &lt;asp:datagrid class="DataGrid1" runat="server" CellSpacing="1" GridLines="None" CellPadding="3" BackColor="White" ForeColor="Black" EnableViewState="False"&gt;
            &lt;HeaderStyle font-bold="True" forecolor="White" backcolor="#4A3C8C"&gt;&lt;/HeaderStyle&gt;
            &lt;ItemStyle backcolor="#DEDFDE"&gt;&lt;/ItemStyle&gt;
        &lt;/asp:datagrid&gt;
        &lt;asp:Button class="Button1" style="Z-INDEX: 100; LEFT: 284px; POSITION: absolute; TOP: 151px" onclick="Button1Click" runat="server" Text="Bind To Data Grid"&gt;&lt;/asp:Button&gt;
        &lt;asp:Label class="Label1" style="Z-INDEX: 100; LEFT: 467px; POSITION: absolute; TOP: 156px" runat="server" Width="42px"&gt;Label&lt;/asp:Label&gt;
        &lt;asp:Button class="Button2" style="Z-INDEX: 101; LEFT: 283px; POSITION: absolute; TOP: 182px" onclick="Button2Click" runat="server" Text="Button"&gt;&lt;/asp:Button&gt;
    &lt;/form&gt;
&lt;/body&gt;
&lt;/html&gt;
</pre>


<p>To make the code execute locally you should download webmatrix which is an</p>
<p>excellent free downloadable aspx development environment. All you need then</p>
<p>is the following code in a web.config document:</p>

<pre>
&lt;configuration&gt;

    &lt;system.web&gt;
&lt;compilation debug="true"&gt;
&lt;assemblies&gt;
  &lt;add assembly="DelphiProvider" /&gt;
&lt;/assemblies&gt;
            &lt;compilers&gt;
                &lt;compiler language="Delphi" extension=".pas" type="Borland.Delphi.DelphiCodeProvider,DelphiProvider" /&gt;
            &lt;/compilers&gt;
        &lt;/compilation&gt;
    &lt;/system.web&gt;
&lt;/configuration&gt;
</pre>

<p>and inside a bin directory at the root the DelphiProvider.dll.</p>
<p>You may now create and run asp.net applications with delphi as you chosen</p>
<p>method of codeing.</p>

