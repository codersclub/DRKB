---
Title: Как создать консольное ASP.NET приложение с событиями Delphi?
Author: andychap@hotmail.com
Date: 01.01.2007
---


Как создать консольное ASP.NET приложение с событиями Delphi?
=============================================================

Ниже приведен полный список файлов ASPX для открытия и чтения базы данных ACCESS.
Очевидно, что объявление `source=c:\mydb.mdb` следует изменить,
чтобы оно указывало на вашу собственную базу данных.

Команды sql также необходимо будет изменить, чтобы они указывали на правильные таблицы и значения.
Этот исходный код является переводом с нативного языка C#.

Любые проблемы с кодом, комментарии или общие нарушения стандартов кодирования следует отправлять
на адрес andychap@hotmail.com.
Пожалуйста, укажите «delphi» в строке темы, чтобы я мог фильтровать нежелательную почту.

Удачи...

В качестве еще одной проблемы у меня также есть несколько примеров,
которые я написал для Delphi для Dot Net, выполняющих аналогичные действия.


    {
    ****************** Below is a complete listing for an ASPX file to open and
    read an ACCESS database. Obviously the source=c:\mydb.mdb declaration should
    be changed to point to your own database. The sql commands will also need to
    be ammended to point to the correct tables and values. This souce code is a
    translation from native c#. Any problems with the code or, thanks, comments
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

Чтобы код выполнялся локально, вам следует загрузить webmatrix,
который является отличной бесплатной загружаемой средой разработки aspx.
Все, что вам нужно, это следующий код в файле web.config:

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

а также разместить DelphiProvider.dll внутри каталога bin в корне.

Теперь вы можете создавать и запускать приложения asp.net с помощью Delphi в соответствии с выбранным вами методом кодирования.
