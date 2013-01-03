---
Title: Как создать консольное ASP.NET приложение с событиями Delphi?
Date: 01.01.2007
---


Как создать консольное ASP.NET приложение с событиями Delphi?
=============================================================

::: {.date}
01.01.2007
:::

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

    <%@ Page Language="Delphi" %>
    <%@ import Namespace="System.Data" %>
    <%@ import Namespace="System.Data.OleDb" %>
    <script runat="server">
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
    </script>
    <html>
    <head>
    </head>
    <body style="FONT-FAMILY: arial">
        <h2>Simple Data Report
        </h2>
        <hr size="1" />
        <form runat="server">
            <asp:datagrid class="DataGrid1" runat="server" CellSpacing="1" GridLines="None" CellPadding="3" BackColor="White" ForeColor="Black" EnableViewState="False">
                <HeaderStyle font-bold="True" forecolor="White" backcolor="#4A3C8C"></HeaderStyle>
                <ItemStyle backcolor="#DEDFDE"></ItemStyle>
            </asp:datagrid>
            <asp:Button class="Button1" style="Z-INDEX: 100; LEFT: 284px; POSITION: absolute; TOP: 151px" onclick="Button1Click" runat="server" Text="Bind To Data Grid"></asp:Button>
            <asp:Label class="Label1" style="Z-INDEX: 100; LEFT: 467px; POSITION: absolute; TOP: 156px" runat="server" Width="42px">Label</asp:Label>
            <asp:Button class="Button2" style="Z-INDEX: 101; LEFT: 283px; POSITION: absolute; TOP: 182px" onclick="Button2Click" runat="server" Text="Button"></asp:Button>
        </form>
    </body>
    </html>

To make the code execute locally you should download webmatrix which is
an

excellent free downloadable aspx development environment. All you need
then

is the following code in a web.config document:

    <configuration>

        <system.web>
    <compilation debug="true">
    <assemblies>
      <add assembly="DelphiProvider" />
    </assemblies>
                <compilers>
                    <compiler language="Delphi" extension=".pas" type="Borland.Delphi.DelphiCodeProvider,DelphiProvider" />
                </compilers>
            </compilation>
        </system.web>
    </configuration>

and inside a bin directory at the root the DelphiProvider.dll.

You may now create and run asp.net applications with delphi as you
chosen

method of codeing.
