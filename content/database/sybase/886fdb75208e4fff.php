<h1>Delphi и SyBase (официальное руководство)</h1>
<div class="date">01.01.2007</div>


<p>Borland Delphi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Using&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SQL Anywhere Studio</p>

<p>Sybase, Inc.</p>
<p>415 Phillip St.</p>
<p>Waterloo, ON</p>
<p>Canada</p>

<p>www.sybase.com</p>

<p>OVERVIEW</p>
<p>Borland Delphi is a rapid application development tool for Windows.&nbsp; Due to the increasing popularity of developing with Delphi and SQL Anywhere Studio, Sybase has provided a white paper on how the two work together, some common issues and methods to resolve those issues.&nbsp; This document will provide you an on-ramp to developing your own applications using Delphi and SQL Anywhere Studio.&nbsp; Appendix D on page 35 has a table of products used to discover the issues and solutions discussed, and their version numbers.&nbsp; Appendix D also lists the web pages of the interfaces discussed in this document.</p>

THE DELPHI ENVIRONMENT</p>
By default, Delphi uses the Borland Database Engine (BDE), a generic Open DataBase Connectivity (ODBC) interface.&nbsp; For greater programming flexibility, Delphi can also use different database interfaces, such as ODBCExpress, Titan SQLAnywhere Developer and NativeDB for SQL Anywhere.&nbsp; ODBCExpress is also a generic ODBC interface built by Datasoft Ltd.&nbsp; When used, ODBCExpress completely bypasses the BDE and compiles into your application.&nbsp; Titan was created by Reggatta Systems and is built using the Adaptive Server Anywhere (ASA) Embedded SQL interface.&nbsp; Titan SQL Anywhere Developer is a set of tools that provide high-speed performance when working with Sybase&#8217;s SQL Anywhere database.&nbsp; NativeDB was built by Liodden Data A/S and uses the Embedded SQL interface.&nbsp; NativeDB was designed to take advantage of the more advanced features of ASA (e.g. callbacks, canceling server execution, resuming SPs etc.).&nbsp; For information regarding setting up ODBCExpress to be used with Delphi, please refer to Appendix A on page 28.&nbsp; For information regarding setting up Titan to be used with Delphi, please refer to Installing Titan and Creating a Titan Alias on page 4.&nbsp; For more information regarding setting up NativeDB to be used with Delphi, please refer to Installing NativeDB for SQL Anywhere on page 6.</p>
&nbsp;</p>
SETTING UP ASA FOR DELPHI COMPATIBILITY</p>
&nbsp;</p>
Creating an ODBC Data Source</p>
Once you have created an Adaptive Server Anywhere (ASA) database it is easy to set it up to be compatible with Delphi.&nbsp; If you have not created an ASA database of your own and would like to modify the ASA 7.0 Sample database supplied to you, please refer to Appendix B for instructions.&nbsp; Since both the BDE and ODBCExpress make use of ODBC, you will need to set up an ODBC data source for your database, following these steps:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Invoke &#8216;Sybase Central 4.0&#8217; (located in Start а Programs а Sybase SQL Anywhere 7 а Sybase Central 4.0, by default).&nbsp; Double click the &#8216;Utilities&#8217; folder located on the left-hand side of Sybase Central, under the title Adaptive Server Anywhere 7.&nbsp; A list of tools appears on the right hand side of the screen</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Double click &#8216;ODBC Administrator&#8217;</td></tr></table></div>&nbsp;</p>
(Another way to get into the &#8216;ODBC Administrator&#8217; is to click Start а Programs а Sybase SQL Anywhere 7а Adaptive Server Anywhere 7 а ODBC Administrator.)</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>If you want a source that is only visible to your login on that machine, make sure you are on the &#8216;User DSN&#8217; tab and click on &#8216;Add&#8217; (Figure 2).&nbsp; If you want a source that is visible to all users on this machine, including NT Services, make sure you are on the &#8216;System DSN&#8217; tab and click &#8216;Add&#8217;</td></tr></table></div>&nbsp;</p>
Figure 2</p>
<img src="/pic/clip0134.png" width="1024" height="768" border="0" alt="clip0134"></p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">4.</td><td>Select &#8216;Adaptive Server Anywhere 7.0&#8217; and click &#8216;Finish&#8217;.&nbsp; This will bring up another window with several tabs (Figure 3)</td></tr></table></div>&nbsp;</p>
Figure 3</p>
<img src="/pic/clip0136.png" width="347" height="435" border="0" alt="clip0136"></p>
&nbsp;</p>
5.&nbsp;&nbsp; The following information must be provided to create an ODBC data source:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 72px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="48">i.</td><td>Under the &#8216;ODBC&#8217; tab, type in a &#8216;Data Source Name&#8217; that pertains to your database.&nbsp; This name will identify the ODBC data source that will be worked with</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 72px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="48">ii.</td><td>Under the &#8216;Login&#8217; tab, click the radio button, &#8216;Supply user ID and password&#8217; and type in a user name and password in the appropriate text boxes</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 72px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="48">iii.</td><td>Under the &#8216;Database&#8217; tab, it is important to supply a path to where your database is saved in the &#8216;Database File&#8217; text box.&nbsp; Type the path or click on the &#8216;Browse&#8217; button, and go to the directory where the database is located and click &#8216;OK&#8217;.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 72px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="48">iv.</td><td>Click the check boxes, &#8216;Automatically start the database if it isn&#8217;t running&#8217; and &#8216;Automatically shut down database after last disconnect&#8217;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 72px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="48">v.</td><td>To make certain that everything is set properly, select the &#8216;ODBC&#8217; tab and click on the button &#8216;Test Connection&#8217;.&nbsp; If everything is correct a window entitled &#8216;Note&#8217; will pop up and let you know that your connection was successful</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 72px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="48">vi.</td><td>Click &#8216;OK&#8217; and you should see the Data Source Name you created in the ODBC Administrator window under the &#8216;User DSN&#8217; tab or the &#8216;System DSN&#8217; tab</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 72px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="48">vii.</td><td>Click &#8216;OK&#8217; again.&nbsp; You have now created an ODBC data source for your database that is ready to be accessed in Delphi</td></tr></table></div>&nbsp;</p>
Titan SQL Anywhere for Delphi 3, version 3.02p, is designed for use with SQL Anywhere versions 5.x.&nbsp; If you have a database that was created in ASA 6.x or ASA 7 you have a few extra steps before starting to create your Delphi application.&nbsp; These extra steps involve a compatibility library and setting up a new Titan alias in the registry.&nbsp; For information on creating a new alias please refer to Installing Titan and Creating a Titan Alias on page 4.</p>
The compatibility library works by attempting to connect to an Adaptive Server Anywhere version 7 interface library, using the supplied connection string.&nbsp; If this attempt fails, the compatibility library attempts to connect to a SQL Anywhere database using the SQL Anywhere version 5 library.&nbsp; For Windows 32-bit (Win32), the compatibility library (dbl50t.dll), the version 5 interface library (dbl50to.dll), and the version 7 interface library (dblib7.dll), are all installed in the same directory.&nbsp; This directory is probably located where you installed ASA.&nbsp; For example, by default it will be stored under C:\Program Files\Sybase\SQL Anywhere 7\win32.&nbsp; In order for the compatibility library to work, the version 7 installation directory must be placed ahead of the version 5 directory in the system path.&nbsp; This placement ensures that the applications locate the compatibility library ahead of the version 5 interface library.&nbsp; Assuming that you have installed the compatibility library in the first place, the version directories will be placed in the correct order automatically.&nbsp; For more information, open the SQL Anywhere documentation, (located in Start а Programs а Sybase SQL Anywhere 7), do a search for &#8216;compatibility&#8217; and double click &#8216;Using the compatibility library&#8217;.</p>
&nbsp;</p>
Installing Titan and Creating a Titan Alias</p>
To set up the Titan SQLAnywhere Developer interface you have to install a package in Delphi, following these steps.</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Select &#8216;Component&#8217; from the tool bar and click &#8216;Install Packages&#8217;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Click the &#8216;Add&#8217; button and select the package &#8216;SQATITAN.DPL&#8217; from the directory where you downloaded Titan</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>Click &#8216;Open&#8217; and then &#8216;OK&#8217; to install</td></tr></table></div>You will notice that another tab named Titan SQL Anywhere appears on the Delphi component bar.</p>
&nbsp;</p>
To set up a new Titan alias in the registry, which must be done in order to use Titan SQL Anywhere with ASA 7.0, follow these steps:</p>
1.&nbsp;&nbsp; Click &#8216;Start&#8217; and select &#8216;Run&#8217; from the menu</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Type in &#8216;regedit&#8217; and click &#8216;OK&#8217;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>Open to &#8216;HKEY_LOCAL_MACHINE а SOFTWARE а Titan а SqlAnywhere а Aliases&#8217; in the &#8216;Registry Editor&#8217; window (Figure 4)</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">4.</td><td>Right click &#8216;Aliases&#8217; and select &#8216;New&#8217; and then &#8216;Key&#8217;</td></tr></table></div>&nbsp;</p>
&nbsp;</p>
Figure 4</p>
<img src="/pic/clip0137.png" width="1024" height="768" border="0" alt="clip0137"></p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">5.</td><td>A folder will appear and you can rename the Alias to better describe your database.&nbsp; This folder will be associated with the database</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">6.</td><td>Right click the alias name you have just created and select &#8216;New&#8217; and then &#8216;String Value&#8217;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">7.</td><td>Do the following:</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">8.</td><td>Type in &#8216;Dynamic&#8217; and press &#8216;Enter&#8217;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">9.</td><td>Double click the name &#8216;Dynamic&#8217; and a box will appear.&nbsp; Type in &#8216;Yes&#8217; in the edit box labled &#8216;Value data&#8217;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">10.</td><td>Repeat steps 6 and 7 for the following:</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">11.</td><td>&#8216;DatabaseFile&#8217; (step 7, part i) and the directory where your database is stored, e.g. &#8216;c:\Program Files\Sybase\ SQL Anywhere 7\asademo.db&#8217; (step 7, part ii)</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">12.</td><td>&#8216;DatabaseName&#8217; and the name of your database, e.g. &#8216;asademo.db&#8217;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">13.</td><td>&#8216;EngineName&#8217; and the name of your engine (in most cases it is the same as the name of your database, e.g. &#8216;asademo&#8217;)</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">14.</td><td>&#8216;Password&#8217; and &#8216;whatever you use for your database password&#8217; (e.g. &#8216;sql&#8217;)</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">15.</td><td>&#8216;User&#8217; and &#8216;whatever you use for your database user id (e.g. &#8216;dba&#8217;)</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">16.</td><td>&#8216;StartCommand&#8217; and the location of the dbeng6 executable (e.g. &#8216;c:\Program Files\Sybase\SQL Anywhere 7\win32\dbeng7.exe&#8217;)</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">17.</td><td>&#8216;AutoStop&#8217; and &#8216;Yes&#8217;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">18.</td><td>Close the &#8216;Registry Editor&#8217; window</td></tr></table></div>&nbsp;</p>
Installing NativeDB for SQL Anywhere</p>
NativeDB does not rely on registry settings, ODBC sources or BDE aliases, so after the following steps are complete, NativeDB is ready to be used with Delphi.</p>
&nbsp;</p>
Similar to installing the Titan interface, you must install two packages in Delphi.&nbsp; The order in which these packages are installed is important, so following these steps carefully.</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>In Delphi select &#8216;Component&#8217; from the tool bar and click &#8216;Install Packages&#8217;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Click the &#8216;Add&#8217; button and select the package &#8216;NdbPack*.dpl&#8217; from the directory where you downloaded NativeDB\NativeDB\Delphi*, where &#8216;*&#8217; should be replaced by the version of Delphi being used</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>Click &#8216;Open&#8217;.&nbsp; You will notice a new entry in the &#8216;Design Packages&#8217; window.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">4.</td><td>Click the &#8216;Add&#8217; button again and this time select the package &#8216;NdbSa*.dpl where &#8216;*&#8217; should be replaced by the version of Delphi being used</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">5.</td><td>Click &#8216;Open&#8217; and then &#8216;OK&#8217; to install</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">6.</td><td>Now select &#8216;Tools&#8217; from the tool bar and click &#8216;Environment Options&#8217;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">7.</td><td>Select the &#8216;Library&#8217; tab</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">8.</td><td>In the &#8216;Library Path&#8217; edit box, add the path to the folder named Delphi* where &#8216;*&#8217; is the version of Delphi being used.&nbsp; An example path would be &#8216;C:\NativeDB\Delphi3&#8217;</td></tr></table></div>On the component bar in Delphi, you will notice another tab named NativeDB.</p>
&nbsp;</p>
&nbsp;</p>
&nbsp;</p>
INTRODUCTION TO DELPHI CONTROLS</p>
Simple Case Setting Bound Control Properties</p>
Delphi was designed so that you can accomplish a number of tasks without ever having to do any actual programming.&nbsp; Certain components can be linked or bound to each other through the &#8216;Object Inspector&#8217; so that they actually interact with one another.&nbsp; For example, using BDE, if you have a table component, &#8216;Table1&#8217;, you can set which database you want the table to be associated with by selecting &#8216;Database Name&#8217; in the &#8216;Object Inspector&#8217;, and selecting from the list.&nbsp; This list contains all the ODBC data sources or Aliases found on your machine.&nbsp; By selecting one of these you have bound the table component to the database you have chosen.</p>
&nbsp;</p>
The diagram below (Figure 5) is an example of how components can be bound together.&nbsp; On the form, &#8216;Form1&#8217;, there are three components from the BDE interface, which have been bound. To bind these three components, follow these steps:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Place the components, &#8216;TTable&#8217;, &#8216;TDataSource&#8217; and &#8216;DBGrid&#8217; on your form</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Bind the &#8216;TTable&#8217; component to the ODBC data source &#8216;ASA 7.0 Sample&#8217; by setting its &#8216;DatabaseName&#8217; property in the &#8216;Object Inspector&#8217; to that name using the drop down list</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>The &#8216;DataSource&#8217; component can be linked to the database through &#8216;Table1&#8217; by selecting the &#8216;DataSource&#8217; component and setting the property &#8216;DataSet&#8217; on the &#8216;Object Inspector&#8217; to &#8216;Table1&#8217; from the drop down list</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">4.</td><td>The &#8216;DBGrid&#8217; component is bound to the database through the &#8216;DataSource&#8217;.&nbsp; This is done by selecting the &#8216;DBGrid&#8217; component on &#8216;Form1&#8217; and setting its &#8216;DataSource&#8217; property, in the &#8216;Object Inspector&#8217;, to &#8216;DataSource1&#8217;.&nbsp; Now &#8216;DBGrid&#8217; can display a table in the database</td></tr></table></div>Setting up a data source is very powerful.&nbsp; It enables many components to get access to the database through this data source without requiring extra programming.&nbsp; The &#8216;DBGrid&#8217; is an example of a component that accesses the database through the &#8216;DataSource&#8217; property.</p>
&nbsp;</p>
Figure 5</p>
<img src="/pic/clip0138.png" width="1024" height="768" border="0" alt="clip0138"></p>
&nbsp;</p>
When binding components to each other certain errors can occur.&nbsp; For example, an &#8216;Access violation&#8217; error will occur when binding a &#8216;TTable&#8217; component with a &#8216;DBGrid&#8217; component.&nbsp; This is a bug in Delphi.&nbsp; For more information on this error, please refer to the DBGrid Examples section on page 18.</p>
&nbsp;</p>
&nbsp;</p>
Connecting To an ASA Database Through Delphi</p>
BDE</p>
The section above discusses binding controls, including the fact that a &#8216;TTable&#8217; component can be bound to an ODBC data source.&nbsp; The reason for binding such components to an ODBC data source is to start the ASA database engine so the other components can access information specific to the database that the source is associated with.&nbsp; For the &#8216;TTable&#8217; component the following steps need to be carried out to start an ASA database engine:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Set the&nbsp; &#8216;TableName&#8217; property, whether it be at design time or run time</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Set the &#8216;Active&#8217; property to True.</td></tr></table></div>&nbsp;</p>
Another BDE component that can start an ASA database engine in Delphi is the &#8216;TDatabase&#8217; component.&nbsp; To do so:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Select the component and place it on the form</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>In the &#8216;Object Inspector&#8217; or when using code, set the &#8216;AliasName&#8217; property.&nbsp; This property is the ODBC data source</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>Set the &#8216;DatabaseName&#8217; property.&nbsp; It is usually the same as the &#8216;AliasName&#8217;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">4.</td><td>Set the &#8216;Connected&#8217; property to &#8216;True&#8217; and the database engine will start up.</td></tr></table></div>&nbsp;</p>
ODBCExpress</p>
Connecting to an ASA database engine using ODBCExpress is similar to using the &#8216;TDatabase&#8217; component using the BDE.&nbsp; To start a database engine follow these steps:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>On the ODBCExpress tab on the component palette, select the &#8216;THdbc&#8217; component and place it on the form.&nbsp;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>In the &#8216;Object Inspector&#8217; or using code, set the &#8216;DataSource&#8217; property to the ODBC data source required</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>Set the &#8216;Connected&#8217; property to &#8216;True&#8217;.</td></tr></table></div>&nbsp;</p>
Titan SQLAnywhere Developer</p>
After creating an Alias name for the database being used (refer to Installing Titan and Creating a Titan Alias on page 4 for details), one is ready to work with Titan components. Place a &#8216;TtsTable&#8217; component or a &#8216;TtsDatabase&#8217; component on the form.&nbsp; For the &#8216;TtsTable&#8217; component:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Set the &#8216;DatabaseName&#8217; property to the Alias name created for the database that is being used</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Set the &#8216;TableName&#8217; property to a table in the database</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>Set the &#8216;Active&#8217; property is set to &#8216;True&#8217;</td></tr></table></div>&nbsp;</p>
For the &#8216;TtsDatabase&#8217; component:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Set the &#8216;AliasName&#8217; property and &#8216;DatabaseName&#8217; property to the Alias name created for the database being accessed</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Set the &#8216;Connected&#8217; property to &#8216;True&#8217;.</td></tr></table></div>
There may be a problem auto-starting an ASA database engine when using the Titan interface. One would like to be able to start the database engine in a similar manner to BDE and ODBCExpress.&nbsp; When attempting to auto-start an ASA engine the error &#8216;Database Name required to start server&#8217; is run into.&nbsp; One way to get around this error is to follow these steps:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Start the database engine required using BDE or ODBCExpress components.&nbsp; Make sure that the Alias names between Titan and BDE or ODBCExpress are the same if you choose this option.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Connect to the already started engine using Titan components</td></tr></table></div>&nbsp;</p>
&nbsp;</p>
NativeDB for SQL Anywhere</p>
Starting an ASA database engine using NativeDB components is slightly different then starting one with any of BDE, ODBCExpress or Titan.&nbsp; The NativeDB component &#8216;TAsaSession&#8217; allows you to connect to any version of ASA from Watcom SQL 4 to ASA 7.&nbsp; For example, to connect to an ASA 7 engine, follow these steps and refer to figure 6:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Place a &#8216;TAsaSession&#8217; component on the form</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Set the &#8216;LibraryFile&#8217; property to &#8216;dblib7.dll&#8217; in the &#8216;Object Inspector&#8217;.&nbsp; Note that this dll will change depending on which version of ASA you are using.&nbsp; For example, this property would be set to &#8216;dblib6.dll&#8217; for ASA 6, &#8216;dbl50t.dll&#8217; for SA5.x, etc.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>Set the &#8216;LoginDatabase&#8217; property to the path and name of where your database is stored (e.g. &#8216;C:\Program Files\Sybase\SQL Anywhere 7\asademo.db).&nbsp; Note that if you are connecting to a running engine then it is enough to only supply the database name in the &#8216;LoginDatabase&#8217; property</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">4.</td><td>Assign a name to the &#8216;LoginEngineName&#8217; property, which will represent the name of your engine.&nbsp; Typically, this is the same name as your database.&nbsp; If this property is left blank the name of the database supplied in the &#8216;LoginDatabase&#8217; property is used for the engine name</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">5.</td><td>Set the &#8216;LoginUser&#8217; to the appropriate user id (e.g. &#8216;dba&#8217;)</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">6.</td><td>Set the &#8216;LoginPassword&#8217; to the correct password for the user supplied by the &#8216;LoginUser&#8217; property (e.g. &#8216;sql&#8217;)</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">7.</td><td>Set the &#8216;ServerParams&#8217; property to the start line for dbeng7 (e.g. &#8216;start=dbeng7.exe&#8217;)</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">8.</td><td>Set the &#8216;ServerType&#8217; property to &#8216;stServer&#8217;</td></tr></table></div>When all of these are set the &#8216;Connected&#8217; property can be set to &#8216;True&#8217; and the database engine will start.</p>
&nbsp;</p>
Figure 6</p>
<img src="/pic/clip0139.png" width="421" height="489" border="0" alt="clip0139"></p>
&nbsp;</p>
Once the &#8216;TAsaSession&#8217; component is set up, you are ready to work with the database access components.&nbsp; To set up the database access component follow these steps:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Place a &#8216;TAsaDataset&#8217; component on the form</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Set the &#8216;Session&#8217; property to the name of the TAsaSession component you set above using the drop down menu (e.g. &#8216;AsaSession1&#8217;)</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>Set the &#8216;SQL&#8217; property to access one or many tables in the database.&nbsp; Note that if this property is not set an error will occur</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">4.</td><td>Set the &#8216;Active&#8217; property to &#8216;True&#8217;</td></tr></table></div>Note that if you set the &#8216;Active&#8217; property to true in the &#8216;TAsaDataset&#8217; component then it is unnecessary to set the &#8216;Connected&#8217; property to &#8216;True&#8217; for the &#8216;TAsaSession&#8217; component previously.&nbsp; When the &#8216;Active&#8217; property is set to &#8216;True&#8217; the database engine described in the &#8216;TAsaSession&#8217; component is started automatically.</p>
&nbsp;</p>
&nbsp;</p>
Blob Examples</p>
One of the most common problems when using an ASA database with Borland Delphi involves Binary Large OBjects, or BLOB.&nbsp; A BLOB is a large data set that must be handled in a special way because of its size.&nbsp; BLOBs are typically image or sound files.&nbsp; Although all of the BLOBs discussed in this section are bitmaps, a BLOB can be any type of information that is turned into binary.</p>
&nbsp;</p>
BDE</p>
A problem involving BLOBs arises when using the BDE for Delphi 3, which is the default engine.&nbsp; It seems that the manipulation of BLOBs larger than 1.4 megabytes is not supported by Delphi.&nbsp; However, manipulating BLOBs under this size can be done without incident. An example of inserting a BLOB into a database using the BDE follows.&nbsp;</p>
&nbsp;</p>
Example 1: Inserting a BLOB into a database using BDE</p>
<pre>
// This procedure puts the BLOB to the table
procedure TForm1.LoadBlobClick(Sender: TObject);
var
   nextnum : Integer;
begin
   // This part of the code attempts to open the table and if it fails it sends an error message
   try
      Table1.Open;
   except
      ShowMessage('Unable to Open Table');
      Table1.Close;
   end;
// Checks if the table is open already
   if Table1.Active = True then
   begin
      // If there are no rows in the table then nextnum is set to 0 otherwise it finds the last 
      // row in the table and sets ‘nextnum’ to the last number in the ‘keyfld’ column plus 1
      if(Table1.RecordCount = 0) then
         nextnum := 1
      else
      begin
         // ** Refer to Appendix C: Primary Key Issues for details on why this is not a good 
         //  method for assigning a value to nextnum and a better method for doing so**
         Table1.Last;
         nextnum := Table1.FieldByName('keyfld').asInteger + 1;
      end;
      // This inserts a row into the table, fills the ‘keyfld’ column using ‘nextnum’ and the 
      // ‘imagefld’ column using the path and name specified by the user through the
      // ‘Edit1’ box
      Table1.Insert;
      Table1.FieldByName('keyfld').Value := (nextnum);
      TBlobfield(Table1.FieldByName('imagefld')).LoadFromFile(Edit1.Text);
      Table1.Post;
      Table1.Close;
      // This displays the BLOB in the ‘Image1’ box
      Image1.Picture.LoadFromFile(Edit1.Text);
      StatusBar1.SimpleText := 'Image loaded into table';
   end;
end;
</pre>

&nbsp;</p>
A few things to note are:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>In this example the BLOB is a bitmap file that is displayed using a &#8216;TImage&#8217; box</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>&#8216;keyfld&#8217; and &#8216;imagefld&#8217; are columns in the table.&nbsp; Keyfld accepts only integer values and is set to the default &#8216;autoincrement&#8217; in ASA.&nbsp; It is also set to be the &#8216;Primary Key&#8217;.&nbsp; This means that every number in the &#8216;keyfld&#8217; column must be unique. Refer to Appendix C: Primary Key Issues on page 34, for more details.&nbsp; &#8216;Imagefld&#8217; accepts only long binary values.&nbsp; Long binary values are used to store BLOBs</td></tr></table></div>&nbsp;</p>
(Note: The Create table statement for table &#8216;blob&#8217; being used here is the following.&nbsp;</p>
&#8216;CREATE TABLE blob ( keyfld int primary key default autoincrement, imagefld long binary)&#8217; )</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>If the bitmap is larger than 1.4 megabytes you will observe the error message,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr></table></div> &nbsp;&nbsp;&nbsp;&nbsp; &#8216;Invalid BLOB length&#8217;</p>
&nbsp;</p>
Figure 7 depicts the sample application created with the code used above.&nbsp; Under &#8216;Pick your Alias&#8217; is a box which lists all the names of your ODBC data sources at run time.&nbsp; In this case, &#8216;DelphiDemo&#8217; is the name of the ODBC data source that connects to the database and table where the images are being stored.&nbsp; The path and filename displayed in the first&nbsp; &#8216;Edit box&#8217; is the location and name of the image that will be displayed and added to the DelphiDemoDb database when clicking on the button &#8216;Load Blob into table&#8217;.</p>
&nbsp;</p>
Figure 7</p>
<img src="/pic/clip0140.png" width="761" height="357" border="0" alt="clip0140"></p>
&nbsp;</p>
Unlike inserting, saving BLOBs of any size to a file creates no problems using BDE.&nbsp; The following is an example of how to save a BLOB to a file.&nbsp; Keep in mind that &#8216;imagefld&#8217; is the name of a column in a table.</p>
&nbsp;</p>
Example 2 : Saving a BLOB to a file using BDE</p>
<pre>
// This procedure gets the BLOB from the Table and saves it to a file
procedure TForm1.SaveBlobToFileClick(Sender: TObject);
begin
   // Tries to open table.  If invalid it sends an error message 
   try
      Table1.Open;
   except
      ShowMessage('Unable to Open Table');
      Table1.Close;
   end;
   // If the table is open then it jumps to the last value and saves the image in ‘imagefld’ to  
   //the path and filename provided by the user through the ‘Edit2’ box.
   if Table1.Active = True then
   begin
      Table1.Last;
      TBlobField(Table1.FieldByName('imagefld')).SaveToFile(Edit2.Text);
      Table1.Close;
       // Displays the image in the ‘Image2’ box
      Image2.Picture.LoadFromFile(Edit2.Text);
      StatusBar1.SimpleText := ('Image saved to ' + Edit2.text);
   end;
end;
</pre>

ODBCExpress</p>
The ODBCExpress engine can be installed so that it can be used with Delphi.&nbsp; For installation instructions, please refer to Appendix A: Setting up Delphi with the ODBCExpress Interface on page 28.&nbsp; Upon installation, Delphi has its own set of ODBCExpress components, which can be used to create Windows applications using this interface instead of, or along with the BDE components.&nbsp; ODBCExpress has full cursor support, which means that it is possible to move backwards, as well as forwards, in a result set without having to cache the rows on the front-end.&nbsp; Since BLOBs are fetched from the database as they are needed, you can have as many BLOBs as you want in your result set without having to worry about running out of memory because of a front-end cache. When testing this using Delphi 3 with an ASA 6.0.3 database and an ASA 7.0 database, it was found that it is possible to manipulate BLOBs of multiple sizes, including ones larger than 1.4 megabytes.&nbsp; Example 3 demonstrates how to insert a BLOB in Delphi using the ODBCExpress engine. Take note that the BLOB in this example is a bitmap.&nbsp; Also recall that &#8216;keyfld&#8217; and &#8216;imagefld&#8217; are columns in the table &#8216;blob&#8217; with data types integer (and default autoincrement), and long binary, respectively.&nbsp;</p>
&nbsp;</p>
Example 3: Inserting a BLOB into a database using ODBCExpress engine</p>
<pre>
// This procedure puts the BLOB into the table and displays the image
procedure TForm1.LoadBlobClick(Sender: TObject);
var
   imagefld : TMemoryStream;
   nextnum : integer;
begin
     // Create a memory stream object
     imagefld := TMemoryStream.Create;
     // Setting the dataset to a specific table (testblob1), opening the dataset and finding the
     // number of rows in the table
     OEDataSet1.Table := 'blob';
     OEDataSet1.Open;
     OEDataSet1.Last;
     // This is the last row in the table plus one
     nextnum := OEDataSet1.FieldValues['keyfld'] + 1;
 
     with Hstmt1 do
     begin
        // Set and prepare an insert statement with a BLOB column, imagefld
        SQL := 'INSERT INTO blob (keyfld, imagefld) VALUES (?, ?)';
        Prepare;
 
        // Assigning values to the parameters
        imagefld.LoadFromFile(Edit1.Text);
 
        // Use the BindBinary method to bind the BLOB
        BindInteger(1, nextnum);
        BindBinary(2, imagefld);
 
        // execute the statement to insert the BLOB at the datasource
        Execute;
     end;
 
     // The memory stream can be destroyed after the execute
     imagefld.Free;
 
     // This displays the image on the screen
     Image1.Picture.LoadFromFile(Edit1.Text);
end;
</pre>

&nbsp;</p>
It should be noted that similar to Example 1, the variable &#8216;nextnum&#8217; is used to provide a value for the &#8216;keyfld&#8217; column.&nbsp; Please refer to Appendix C: Primary Key Issues on page 33 for details describing a better method for providing a value.&nbsp; It should also be noted that the syntax is slightly different from the BDE.&nbsp; Also, the line:</p>
 OEDataSet1.Table := &#8216;blob&#8217;;</p>
is the programmatic way of assigning a table name to the data source.&nbsp; The alternative method, used for examples one and two, is to select your &#8216;TTable&#8217; component on your form and beside the &#8216;Table Name&#8217; property in the &#8216;Object Inspector&#8217; type in the name of the table you want to access.&nbsp; In addition to manipulating BLOBs of any size, ODBCExpress also manipulates BLOBs with great speed.</p>
&nbsp;</p>
Figure 8 is a picture of the application generated by the code outlined above.&nbsp; Here, &#8216;DelphiDemo&#8217; is the name of the ODBC data source that connects to the database with the table &#8216;blob&#8217;.&nbsp; The path and filename written in the first &#8216;Edit&#8217; box is the location and name of the image that will be displayed and loaded into the table when the button &#8216;Load Blob into Table&#8217; is clicked.&nbsp; The picture displayed here could not be displayed using the BDE because it is larger then 1.4 megabytes in size.</p>
&nbsp;</p>
&nbsp;</p>
&nbsp;</p>
&nbsp;</p>
&nbsp;</p>
Figure 8</p>
<img src="/pic/clip0142.png" width="700" height="432" border="0" alt="clip0142"></p>
&nbsp;</p>
Saving BLOBs using ODBCExpress is similar to saving them using BDE.&nbsp; The following example displays how this can be accomplished.&nbsp; Recall that &#8216;blob&#8217; is the name of the table being accessed and &#8216;imagefld&#8217; is the name of a column in blob.</p>
&nbsp;</p>
Example 4: Saving a BLOB to a file using ODBCExpress</p>
<pre>
procedure TForm1.SaveBlobClick(Sender: TObject);
begin
     OEDataSet1.Table := 'blob';
     // Opens the table if possible and if not sends an error message
     try
        OEDataSet1.Open;
     except
        ShowMessage('Unable to Open Table');
        OEDataSet1.Close;
     end;
     // If the table is open, then jump to the last row in the table and save the last value in 
     // the ‘imagefld’ column to the path and filename provided by the user through the 
     // ‘Edit2’ box
     if OEDataSet1.Active = True then
     begin
        OEDataSet1.Last;
        TBlobField(OEDataSet1.FieldByName('imagefld')).SaveToFile(Edit2.Text);
        // This displays the image just saved in the image box Image2
        Image2.Picture.LoadFromFile(Edit2.Text);
     end;
end;
</pre>

&nbsp;</p>
Titan SQLAnywhere Developer</p>
Similar to ODBCExpress, Titan SQLAnywhere Developer can be installed so that it can interact with Delphi.&nbsp; Please see Installing Titan and Creating a Titan Alias on page 4, for more details on how to install this product.&nbsp; Although Titan SQLAnywhere Developer has its own set of components when installed, it was designed so that it could interact with the standard Delphi components.&nbsp; When using the Titan components, manipulating BLOBs of multiple sizes is possible.&nbsp; Example 5 illustrates how Titan SQLAnywhere Developer loads a BLOB into a table.&nbsp; Some things to note are listed below:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>&#8216;blob&#8217; is the name of the table where the BLOB, which is a bitmap, will be stored.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Recall that &#8216;blob&#8217; has two columns, &#8216;keyfld&#8217; and &#8216;imagefld&#8217;.&nbsp; The column &#8216;keyfld&#8217; has the data type of &#8216;integer&#8217; and is set to &#8216;autoincrement&#8217;.&nbsp; The column &#8216;imagefld&#8217; has the data type &#8216;long binary&#8217;.&nbsp;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>The syntax for this example is almost identical to that of Example 1.&nbsp; The differences are the following:</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">4.</td><td>Since the &#8216;tsTable&#8217; component is used instead of the &#8216;TTable&#8217; component, the word &#8216;Table1&#8217; in Example 1 is replaced with &#8216;tsTable1&#8217; in this example.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">5.</td><td>This example does not insert a number into the column &#8216;keyfld&#8217;.&nbsp; Example 1 does this through the variable nextnum, which is assigned a value by going to the last row in the table and adding one to the value in the &#8216;keyfld&#8217; column.&nbsp; Appendix C: Primary Key Issues discusses different methods for assigning values to nextnum and why the method used in Example 5 is recommended over the method used in Example 1.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">6.</td><td>The line &#8216;tsDatabase1.Commit&#8217;.&nbsp; This is necessary when using Titan SQLAnywhere Developer because the default value for committing changes is set differently than the default for BDE or ODBCExpress.&nbsp; If this line is not placed into the code, the image will be placed into the table initially but when the table is closed the change will be rolled back.</td></tr></table></div>&nbsp;</p>
Example 5:&nbsp; Loading a BLOB into a file using Titan SQLAnywhere</p>
<pre>
procedure TForm1.LoadBlobButtonClick(Sender: TObject);
begin
   tsTable1.TableName := 'blob';
   try
      tsTable1.Open;
   except
      ShowMessage('Unable to Open Table');
      tsTable1.Close;
   end;
 
   if tsTable1.Active = True then
   begin
      // inserting a BLOB into the table blob
      tsTable1.Fields[0].Required := false;  // this statement allows autoincrement to work
      tsTable1.Insert;
      TBlobField(tsTable1.FieldByName('imagefld')).LoadFromFile(Edit1.Text);
      tsTable1.Post;
      tsDatabase1.Commit;
      tsTable1.Close;
      // Displaying the BLOB in image1
      Image1.Picture.LoadFromFile(Edit1.Text);
   end;
end;
</pre>

Saving a BLOB to a file using Titan SQLAnywhere Developer is a simple task.&nbsp; Note that the syntax is identical to that of Example 2 with the exception &#8216;Table1&#8217; is replaced by &#8216;tsTable1&#8217; in this example.</p>
&nbsp;</p>
Example 6:&nbsp; Saving a BLOB to a file using Titan SQLAnywhere</p>
<pre>
procedure TForm1.SaveBlobToFileButtonClick(Sender: TObject);
begin
   // Attempts to open table and sends an error message if this is not possible
   try
      tsTable1.Open;
   except
      ShowMessage('Unable to Open Table');
      tsTable1.Close;
   end;
 
   // if the table is active this code goes to the last row in the table and saves the image in 
   // the ‘imagefld’ to the path and file name written by the user in the ‘Edit2’ box.
   if tsTable1.Active = True then
   begin
      tsTable1.Last;
      TBlobField(tsTable1.FieldByName('imagefld')).SaveToFile(Edit2.Text);
      tsTable1.Close;
      Image2.Picture.LoadFromFile(Edit2.Text);
      StatusBar1.SimpleText := ('Image saved to ' + Edit2.Text);
   end;
end;
</pre>

NativeDB for SQL Anywhere</p>
Similar to ODBCExpress and Titan SQLAnywhere Developer, NativeDB can be installed so that it can interact with Delphi.&nbsp; For more information regarding installing NativeDB for SQL Anywhere, please refer to Installing NativeDB for SQL Anywhere on page 6.&nbsp; The NativeDB components were designed to interact with the standard Delphi components, similar to Titan SQLAnywhere Developer.&nbsp; The components supplied by NativeDB are used more for interacting with the database.&nbsp;</p>
&nbsp;</p>
BLOBs of all sizes can be manipulated using NativeDB components.&nbsp; Example 7 below illustrates how NativeDB loads a BLOB into a table.&nbsp;</p>
&nbsp;</p>
Example 7: Loading a BLOB into a database using NativeDB</p>
<pre>
procedure TForm1. LoadBlobClick(Sender: TObject);
begin
      // This attempts to open the table and if it fails it sends an error message
      try
          AsaDataset1.Open;
      except
          ShowMessage(‘Unable to Open Table’);
          AsaDataset1.Close;
      end;
 
      //Checks if the table is open already.  If so, it loads the selected blob into the database
      if AsaDataset1.Active = True then
      begin
          // This inserts a row into the table, fills the 'imagefld' column using the path and 
          // name specified by the user through the 'Edit1' box
          AsaDataset1.Insert;
          TBlobField(AsaDataset1.FieldByName('imagefld')).LoadFromFile(Edit1.Text);
          AsaDataset1.Post;
          AsaSession1.Commit;
          AsaDataset1.Close;
 
          // This displays the BLOB in the 'Image1' box
          Image1.Picture.LoadFromFile(Edit1.Text);
       end;
end;
</pre>

&nbsp;</p>
Some things to note are the following:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>It is not obvious which table is being accessed in this example.&nbsp; The &#8216;SQL&#8217; property for the &#8216;TAsaDataset&#8217; component is set to &#8216;Select * from blob&#8217; meaning that the table &#8216;blob&#8217; is being accessed. Recall that table &#8216;blob&#8217; has two columns, &#8216;keyfld&#8217; and &#8216;imagefld&#8217;.&nbsp; The column &#8216;keyfld&#8217; has the data type of &#8216;integer&#8217; and default &#8216;autoincrement&#8217;.&nbsp; The column &#8216;imagefld&#8217; has the data type &#8216;long binary&#8217;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Unlike BDE, ODBCExpress, and Titan, NativeDB deals with the default &#8216;autoincrement&#8217; automatically.&nbsp; It does this by setting AsaDataset.Fields[0].Required to false initially.&nbsp; Please refer to Appendix C: Primary Key Issues, for more information</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>It is also not obvious that the &#8216;ReadOnly&#8217; property in the &#8216;TAsaDataset&#8217; component is automatically set to &#8216;False&#8217;.&nbsp; This means that the BLOBs are not actually loaded into the table.&nbsp; When this property is set to &#8216;True&#8217; then the BLOBs will be inserted into the table</td></tr></table></div>&nbsp;</p>
Saving a BLOB to a file using NativeDB is almost identical to saving a file using BDE components.&nbsp; In fact, the syntax for Example 8, using NativeDB components is identical to that of Example 2, using BDE components, with the exception of &#8216;Table1&#8217; in Example 2 is replaced by &#8216;AsaDataset1&#8217; in Example 8.&nbsp; Another difference is that NativeDB has to explicitly commit the postings, similar to Titan, but only if the &#8216;AsaSession1&#8217; component has its &#8216;AutoCommit&#8217; set to &#8216;False&#8217;.</p>
&nbsp;</p>
Example 8: Saving a BLOB to a file using NativeDB</p>
<pre>
procedure TForm1. SaveBlobToFileClick(Sender: TObject);
begin
      // Tries to open table.  If unsuccessful it sends an error message
      try
          AsaDataset1.Open;
      except
          ShowMessage(‘Unable to Open Table’);
          AsaDataset1.Close;
      end;
 
      // If the table is open then it jumps to the last value and saves the image in ‘imagefld’
      // to the path and name specified by the user in the ‘Edit2’ box
      if AsaDataset1.Active = True then
      begin
          AsaDataset1.Last;
          TBlobField(AsaDataset1.FieldByName(‘imagefld’)).SaveToFile(Edit2.Text);
          AsaDataset1.Close;
 
 
 
          // Displays the image in the ‘Image2’ box
          Image2.Picture.LoadFromFile(Edit2.Text);
      end;
end;
</pre>

&nbsp;</p>
DBGrid Examples</p>
A &#8216;DBGrid&#8217; is a data aware component that can be found on the &#8216;Data Control&#8217; tab of the component pallet in Delphi.&nbsp; A data aware component is &#8216;aware&#8217; of the data stored in a database when it is bound to a data source.&nbsp; When working with Delphi and ASA, there have been known problems in the past when using a &#8216;DBGrid&#8217; component.&nbsp; To solve these problems Sybase created a check box called &#8216;Delphi applications&#8217; that can be seen when configuring your ODBC data source.&nbsp; Please refer to Figure 3 on page 3 to see where this check box can be found.&nbsp; Any time you are working with a &#8216;DBGrid&#8217; component this check box should be checked off for your ODBC data source.&nbsp; Note: it has been found that the &#8216;DBGrid&#8217; component uses bookmarks with the ODBCExpress and BDE interfaces.&nbsp; For more information on bookmarks refer to ODBCExpress on page 24.</p>
&nbsp;</p>
BDE</p>
When just getting started with &#8216;DBGrid&#8217; using BDE, there are a few things that must be set up.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>The &#8216;Table&#8217;, &#8216;DataSouce&#8217;, and &#8216;DBGrid&#8217; properties have been bound to each other. (Recall that binding components was talked about in the section Simple Case Setting Bound Control Properties on page 6)</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>To ensure that &#8216;DBGrid&#8217; will display the information in your database the &#8216;Active&#8217; property must be set to true. One way to set this property is to select your &#8216;Table&#8217; component on your form, and in the &#8216;Object Inspector&#8217; on the &#8216;Properties&#8217; tab, the &#8216;Active&#8217; property can be seen.&nbsp; The &#8216;Active&#8217; property must be set to True otherwise your data will not appear in the &#8216;DBGrid&#8217; even when the application is running.&nbsp; Note that the &#8216;Active&#8217; property can only be set to true once a &#8216;Table Name&#8217; has been supplied.</td></tr></table></div>&nbsp;</p>
Figure 9 depicts a &#8216;DBGrid&#8217; application, whose &#8216;TTable&#8217; component is having its &#8216;Active&#8217; property set to true.</p>
&nbsp;</p>
&nbsp;</p>
Figure 9</p>
<img src="/pic/clip0143.png" width="1024" height="768" border="0" alt="clip0143"></p>
&nbsp;</p>
Setting the &#8216;Active&#8217; property to &#8216;True&#8217; causes an error when exiting Delphi.&nbsp; The error &#8216;Access violation at address 1F4ADCD4.&nbsp; Read of address 1F4ADCD4&#8217; will appear.&nbsp; This error is not serious and does not effect your application in any way.&nbsp; It is thought that the error comes about only because Delphi recognizes that the connection is being broken between the ASA engine and the application, and generates an error message because it is still trying to display the information from the database.</p>
&nbsp;</p>
When an application is compiled and run, an executable file is created with the same name as what you called your Project.&nbsp; It can be found in the same place you saved your Project and if this file is executed (e.g. from Windows Explorer), it runs your application.&nbsp; Closing this executable file does not create the error, which is why the error does not effect your application.</p>
&nbsp;</p>
To avoid the above error it is recommended that you write an event that sets the &#8216;Active&#8217; property to true and then sets it back to false when finished.&nbsp; For example, a button can be clicked to display the data in the table, and an &#8216;OnClose&#8217; event can be set up so that when the form is closed, the &#8216;Active&#8217; property is set to false.&nbsp; The following two procedures can accomplish these tasks.&nbsp; Note that the &#8216;Active&#8217; property must be set to false and the &#8216;Table Name&#8217; property must be blank in the &#8216;Object Inspector&#8217; for these procedures to take effect.&nbsp; Also, the button that is to be clicked (which can be seen on the form in Figure 9 above, labeled &#8216;Display Table&#8217;) has the &#8216;Name&#8217; DisplayButton, and on the &#8216;Events&#8217; tab in the &#8216;Object Inspector&#8217;, the event &#8216;OnClick&#8217; is set to the procedure &#8216;DisplayButtonClick&#8217;.&nbsp; Lastly, on the &#8216;Events&#8217; tab for the Form, the event &#8216;OnClose&#8217; is set to &#8216;FormClose&#8217;.</p>
<pre>
procedure TForm1.DisplayButtonClick(Sender: TObject);
begin
     // This binds the table component to the table ‘Grid’
     Table1.TableName := 'Grid';
     // This sets the ‘Active’ property to true
     Table1.Active := True;
end;
 
// This procedure sets the ‘Active’ property to false when a user closes the form
procedure TForm1.FormClose(Sender: TObject; var Action: TCloseAction);
begin
     Table1.Active := False;
end; 
</pre>

When testing this problem using Delphi 5, it was found that using events to set the &#8216;Active&#8217; property to &#8216;True&#8217; and &#8216;False&#8217; is not necessary.&nbsp; The error no longer occurs when closing Delphi.&nbsp; It is still good practice to set these events up so that &#8216;Active&#8217; is not left set to &#8216;True&#8217;.</p>
&nbsp;</p>
An easy way to add and delete rows, move forwards and backwards through the records, and edit your table through &#8216;DBGrid&#8217; is to use the component &#8216;DBNavigator&#8217;.&nbsp; In order to do this the component must be bound to your &#8216;DataSource&#8217;, by selecting the &#8216;DBNavigator&#8217; component, and setting the &#8216;DataSource&#8217; property in the &#8216;Object Inspector&#8217;.&nbsp; A small problem that you can run into when using &#8216;DBNavigator&#8217; occurs when inserting a row.&nbsp; If you click on the &#8216;+&#8217; button located on the Navigator bar at run time, a blank row is inserted where you type in values.&nbsp; To post values that are entered, click on the &#8216;3&#8217; button which is also located on the navigation component.&nbsp; At this point, you cannot see the row you have just added until you refresh the table.&nbsp; To perform a refresh, press the button &#8216;?&#8217; (Refresh).&nbsp; However, as a result the error, &#8216;Table does not support this operation because it is not uniquely indexed&#8217; may occur.&nbsp; To fix this problem, select the &#8216;Table&#8217; component on your form and set the &#8216;IndexFieldName&#8217; property in the &#8216;Object Inspector&#8217; to one of the column names in your table.&nbsp; When this is done, it enables identification of the rows in the table and therefore you can refresh the table so newly entered rows can be seen.&nbsp; This procedure also orders the rows in your table by this column.&nbsp; For example, if you selected your &#8216;IndexFieldName&#8217; to be &#8216;id&#8217; which is an integer field, your rows would be ordered numerically in ascending order.&nbsp;</p>
&nbsp;</p>
When the &#8216;Active&#8217; property is set to true, whether through code or through the &#8216;Object Inspector&#8217;, a SQL statement is executed which fetches rows in the table.&nbsp; When the &#8216;IndexFieldName&#8217; property is left blank the SQL statement that is executed is, &#8216;SELECT id, name FROM Grid&#8217;.&nbsp; In this case, id and name are the names of all the columns in the table Grid.&nbsp; When the &#8216;IndexFieldName&#8217; is set to one of the columns in the table, (i.e. id), then the following statement is executed instead.&nbsp; SELECT id, name FROM Grid ORDER BY id.&nbsp; The ORDER BY clause sorts the rows according to the column specified in the &#8216;IndexFieldName&#8217; property.&nbsp; Once the rows are fetched in a certain order Delphi recognizes that the table has a unique index and therefore the table can be refreshed.&nbsp; It should be noted that if the column chosen is not the primary key, then it is a good idea to place an index on the column.&nbsp; Doing so will improve performance.&nbsp; For more information about indexes please refer to the “SQL Anywhere documentation” (located under Start а Programs а Sybase SQL Anywhere 7а SQL Anywhere documentation).&nbsp;</p>
&nbsp;</p>
Figure 10 depicts the &#8216;IndexFieldName&#8217; property being set to the column &#8216;id&#8217;.&nbsp; The &#8216;DBNavigator&#8217; component is circled.</p>
&nbsp;</p>
Figure 10</p>
<img src="/pic/clip0144.png" width="1024" height="768" border="0" alt="clip0144"></p>
&nbsp;</p>
A problem may also arise when using an ASA table that has a column with the data type &#8216;Integer&#8217; and the default &#8216;Autoincrement&#8217;.&nbsp; The problem occurs when inserting a row into the &#8216;DBGrid&#8217; using the &#8216;DBNavigator&#8217;.&nbsp; Delphi does not understand that this column will provide a value for itself, if one is not specified.&nbsp; When inserting a row you would like to be able to simply type values for the rest of the columns and click &#8216;3&#8217; on the &#8216;DBNavigator&#8217; component to post your new row.&nbsp; You might expect the autoincrement will add a number for that row.&nbsp; What happens is the error &#8216;Field ID must have a value&#8217; occurs where &#8216;ID&#8217; is the name of the column with the autoincrement default which you left blank, assuming it would increment itself.&nbsp; This error occurs because Delphi automatically sets the TField.Required property to True.&nbsp; To fix this, so that &#8216;DBGrid&#8217; makes use of autoincrement, follow these steps:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Select the &#8216;Form&#8217;, making sure that a component on the form is not highlighted.&nbsp; Make sure that the display on the top of the &#8216;Object Inspector&#8217; says Form1 : TForm, or what you named your form : TForm</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Select the &#8216;Events&#8217; tab on the &#8216;Object Inspector&#8217; and make the row &#8216;OnShow&#8217; the focus.&nbsp; Double click the white space to the right of the name &#8216;OnShow&#8217;.&nbsp; This will create a procedure header named &#8216;FormShow&#8217; where code is to be written.&nbsp; (Note: creating this procedure in the &#8216;OnShow&#8217; event ensures that the autoincrement feature will work as soon as the application is run)</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>Make your procedure &#8216;FormShow&#8217; look like the following by adding lines of code</td></tr></table></div>
<pre>
procedure TForm1.FormShow(Sender: TObject);
begin
      Table1.Fields[0].Required := False;
end;
</pre>

&nbsp;</p>
It should be noted that Delphi associates each column in a table with a number, starting at 0.&nbsp; In the above code the number 0 represents the column which has autoincrement set as its default in ASA.</p>
&nbsp;</p>
The above procedure only works if the &#8216;Active&#8217; property is set to &#8216;True&#8217;.&nbsp; If this is not the case then upon running the application, the error &#8216;List index out of bounds (0)&#8217; will occur because the form shows no columns in &#8216;DBGrid&#8217; when the &#8216;Active&#8217; property is false.&nbsp; To get around this error, the line of code,&nbsp;&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Table1.Fields[0].Required := False;</p>
should be placed in another event, such as a button click event discussed above.</p>
A small problem when using &#8216;DBGrid&#8217; with an ASA database arises when a column in the table being displayed has the data type &#8216;long varchar&#8217;.&nbsp; If this is the case, &#8216;DBGrid&#8217; displays &#8216;(MEMO)&#8217; in place of what is actually in the database under that column.&nbsp; It seems that a column in the &#8216;DBGrid&#8217; can not display a string of that size.&nbsp; A &#8216;DBMemo&#8217; component seems to be the only data aware component that can view a data type of that size.&nbsp; To set up a &#8216;DBMemo&#8217; component that displays the values for a particular column do the following:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Select the &#8216;DBMemo&#8217; component on the form</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Set the &#8216;DataSource&#8217; property appropriately</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>Set the &#8216;DataField&#8217; property to the name of the column you wish to display.</td></tr></table></div>&nbsp;</p>
All of the examples and problems discussed above use the &#8216;TTable&#8217; component.&nbsp; Another component that can be used to access a table in a database is the &#8216;TQuery&#8217; component.&nbsp; Using this component, you can still display the table using a &#8216;DBGrid&#8217; component, however, now there is greater flexibility.&nbsp; With &#8216;TTable&#8217;, &#8216;DBGrid&#8217; displays all columns and all rows in a table.&nbsp; Using &#8216;TQuery&#8217;, SQL statements can be made so that only the columns and rows wanted are displayed.&nbsp; The records that are displayed after the SQL statement is executed are called the &#8216;Result Set&#8217; of the query.</p>
&nbsp;</p>
Figure 11 depicts an application where a result set from a query (the Query component is circled) is displayed in the &#8216;DBGrid&#8217; component.&nbsp; When the &#8216;Edit1&#8217; box under the title &#8216;Type ORDER BY or WHERE clause Here&#8217; is left empty and the &#8216;Display Table&#8217; button is clicked, the result set is that of the entire table.&nbsp; When a &#8216;Where&#8217; clause is included and the &#8216;Display Table&#8217; button is clicked, a select group of rows and columns are displayed.&nbsp;</p>
&nbsp;</p>
An example of a SQL statement with a &#8216;Where&#8217; clause is:</p>
SELECT id FROM Grid WHERE name = &#8216;your name&#8217;</p>
In this statement &#8216;id&#8217; is the column in the table &#8216;Grid&#8217; that will be displayed, but only those rows where the &#8216;name&#8217; column has the value &#8216;your name&#8217;.&nbsp;</p>
When the &#8216;Order By&#8217; clause is included and the &#8216;Display Table&#8217; button is clicked, the entire table is displayed in a specific order.&nbsp; An example of a SQL statement with an &#8216;Order By&#8217; clause is:</p>
SELECT * FROM Grid ORDER BY id</p>
This statement selects all rows and columns in the table &#8216;Grid&#8217; and orders the rows according to the value in the &#8216;id&#8217; column.&nbsp;</p>
&nbsp;</p>
When both clauses are included and the button &#8216;Display Table&#8217; is clicked, a select group of rows and columns are displayed in a certain order.&nbsp; An example of an SQL statement where both clauses are included is:</p>
SELECT * FROM Grid WHERE name = &#8216;your name&#8217; ORDER BY id</p>
This statement selects all the columns in the table Grid where the value in the &#8216;name&#8217; column is &#8216;your name&#8217; and displays them in order of the value in the &#8216;id&#8217; column.&nbsp;</p>
&nbsp;</p>
Since an SQL statement is used to populate the &#8216;DBGrid&#8217;, the &#8216;IndexFieldNames&#8217; property, discussed above, does not exist and is not needed.&nbsp; To sort a displayed table, the &#8216;Order By&#8217; clause can be placed in the SQL statement.&nbsp; To refresh the table after it has been modified, the SQL statement just has to be rerun.&nbsp;</p>
&nbsp;</p>
Figure 11</p>
<img src="/pic/clip0145.png" width="1024" height="768" border="0" alt="clip0145"></p>
&nbsp;</p>
The &#8216;TQuery&#8217; component, when used with a &#8216;DBGrid&#8217; component can do much more then what is described above.&nbsp; Not only can you display the result set of a query done on one table in a database, but you can also display the result set of a query done on several tables in a database, by changing the SQL statement that is executed.&nbsp; An example of an SQL statement that involves more than one table is:</p>
&nbsp;</p>
SELECT * FROM Grid, AnotherGrid WHERE Grid.Name = &#8216;your name&#8217;</p>
Assume that &#8216;Name&#8217; is a column in the table &#8216;Grid&#8217;.&nbsp; This statement will take all the columns in both Grid and AnotherGrid, and display only the rows where Name = &#8216;your name&#8217; in Grid.&nbsp;</p>
&nbsp;</p>
Since two separate tables are involved in the query above editing the result set is not an option.&nbsp; That is, inserting rows, deleting rows or editing existing rows cannot be done using typical methods with this interface.&nbsp;</p>
&nbsp;</p>
ODBCExpress</p>
Using a &#8216;DBGrid&#8217; component with ODBCExpress is slightly different than using it with the BDE.&nbsp; ODBCExpress does not have a &#8216;Table&#8217; component but instead uses an &#8216;OEDataSet&#8217; component.&nbsp; Since there needs to be a way of binding the &#8216;DBGrid&#8217; with the &#8216;OEDataSet&#8217;, the BDE &#8216;DataSource&#8217; component is added to the form.&nbsp; Now the Grid has a way of communicating with the database.&nbsp; An interesting feature of the &#8216;OEDataSet&#8217; is that it has an &#8216;SQL&#8217; property.&nbsp; This means that SQL statements can be run on a table in a database to display the information in different ways.&nbsp; This gives the &#8216;OEDataSet&#8217; component similar functionality to the BDE &#8216;Query&#8217; component.&nbsp; Similar to using a &#8216;DBGrid&#8217; component with BDE, the &#8216;Active&#8217; property for the &#8216;OEDataSet&#8217; component must be set to True to display a table in the &#8216;DBGrid&#8217;.&nbsp; If this component is set at design time then the Access violation error occurs when closing Delphi, similar to BDE.&nbsp; This problem is discussed on page 19 and the recommended solution can be found there. Another notable difference between ODBCExpress and BDE is that ODBCExpress uses scrollable cursors.&nbsp; Testing this problem using Delphi 5 revealed that the problem was fixed for this version.&nbsp; Although these problems were discovered using ASA 6.0.3, when tested using ASA 7.0 the problems remain.&nbsp; Please refer to Appendix D for versions of ASA where the problems were addressed.</p>
&nbsp;</p>
Some interesting problems can occur when using ODBCExpress with a &#8216;DBGrid&#8217; component.&nbsp; Inserting rows into a table can be difficult.&nbsp; It is not obvious that the &#8216;OEDataSet&#8217; component has a default value of Read Only for the result set from the SQL statement.&nbsp; This means that when an attempt to insert, delete, or update a row is done, the error &#8216;Option value out of range&#8217; is given.&nbsp; Follow these steps to avoid this error:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Select the &#8216;OEDataSet&#8217; component on your form</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Double click &#8216;+&#8217; to the left of the &#8216;hStmt&#8217; property in the &#8216;Object Inspector&#8217;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>Select the property &#8216;Concurrency Type&#8217; and choose &#8216;Values&#8217; or &#8216;Row Versions&#8217; from the drop down list.&nbsp;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">4.</td><td>The &#8216;OEDataSet&#8217; component also has a property &#8216;Editable&#8217; which is automatically set to &#8216;False&#8217;.&nbsp; If data is to be edited at run time, this property must be set to &#8216;True&#8217;.&nbsp;</td></tr></table></div>&nbsp;</p>
Of the three interfaces discussed in this document, ODBCExpress seems to be the only one where the type of cursor used can be changed.&nbsp; To change the type of cursor:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Select the &#8216;OEDataSet&#8217; component on the form</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>In the &#8216;Object Inspector&#8217; double click on the &#8216;+&#8217; to the left of the &#8216;hStmt&#8217; property.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>In the expanded list, the property &#8216;CursorType&#8217; can be seen and one of Forward-Only, Dynamic, Keyset-Driven, or Static can be chosen from a drop down list.</td></tr></table></div>For more information on these cursors, please refer to the whitepaper, OEWPaper.pdf, under the section &#8216;Cursor Types&#8217;, which is provided by Datasoft when ODBCExpress is downloaded.</p>
Since the rows that make up the result sets in Static and Keyset-Driven cursors remain static, it is possible to retrieve bookmark values for these cursors.&nbsp; Bookmarks are values used to identify rows in a cursor and are generally based on position in a result set.&nbsp; They remain valid for the duration of the result set only.&nbsp; Forward-only and Dynamic cursors are generally not able to return bookmark values for rows.&nbsp; Therefore, if Dynamic is chosen, a problem occurs when trying to scroll through result sets containing many rows that are displayed in data-aware controls.&nbsp; An attempt to scroll through the result set will often result in the error &#8216;Fetch type out of range&#8217;.&nbsp; Attempts to insert, delete or edit rows in the result set produce the same error.&nbsp; If the Forward- Only cursor is chosen, it will create the same error when attempting to scroll backward through the result set.&nbsp; Again, inserting, deleting, and editing rows in the result set generate this error.&nbsp; Therefore, when using a &#8216;OEDataSet&#8217; component where bookmarks are required, it is recommended that a Keyset-Driven or a Static cursor be used. There are options in Delphi 5 that can be set so that Forward-Only and Dynamic cursors can be used without error.&nbsp; To set these options:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Select the &#8216;OEDataSet&#8217; component on the form</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>In the &#8216;Object Inspector&#8217; set the &#8216;Cached&#8217; property to true</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>Click on the &#8216;+&#8217; beside the &#8216;hStmt&#8217; property</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">4.</td><td>Set the &#8216;CursorType&#8217; property to either Dynamic or Forward-Only</td></tr></table></div>&nbsp;</p>
When this is done scrolling, both backwards and forwards in the result set is allowed, as well as inserting, deleting and editing rows.</p>
&nbsp;</p>
When a result set is static (i.e., when using a Static cursor, or a Keyset-Driven cursor) and the &#8216;OEDataSet&#8217; component is used, unexpected results can occur when inserting a row, deleting a row, or editing a row in the result set.&nbsp; When using a Static cursor with ASA version 6.0.3.2747, an error occurs when deleting a row.&nbsp; When you click &#8216;OK&#8217;, all of the rows that were in your table disappear except for one.&nbsp; This problem was addressed with in the EBF for ASA 6.0.3.&nbsp; Instead of the initial error, the comment &#8216;Invalid cursor state&#8217; is given.</p>
&nbsp;</p>
Using the &#8216;Keyset Driven&#8217; cursor allowed rows to be deleted.&nbsp; However, when the result set is closed and reopened, the rows that were deleted will reappear.&nbsp; This happens even when a &#8216;Commit&#8217; is explicitly written.&nbsp; The ebf for ASA fixes the problem of the rows reappearing but leaves another one.&nbsp; Occasionally the error &#8216;Invalid cursor state&#8217; will arise, due to the following conditions.&nbsp; Since the result set is static, a row being manipulated is not physically added, removed or changed.&nbsp; Visually this means that inserted rows should disappear, deleted rows should reappear, and changed rows should remain the same.&nbsp; However, since the &#8216;TOEDataSet&#8217; component is a descendant of the &#8216;TDataSet&#8217; component, and its required behaviour is to have inserted rows remain, deleted rows disappear, and edited rows change, ODBCExpress alters its typical behaviour to behave similar to the &#8216;TDataSet&#8217; component.&nbsp; To behave similarly to the &#8216;TDataSet&#8217; component, &#8216;TOEDataSet&#8217; keeps track of the deleted and modified rows and adjusts the visual display accordingly.&nbsp; Therefore, when the result set is reopened, rows deleted will reappear and rows edited will go back to their original values.&nbsp; For rows inserted, the only way to bypass the problem of the rows disappearing is to keep track of the primary keys of the inserted row, then close and re-open the result set, and then position to the inserted row which might now form part of the new result set.</p>
Installing the file dbodbc6.dll, which has the same version number as the ebf (refer to Appendix D on page 35 for details), into the directory where all the ASA dll&#8217;s are, solves the &#8216;Invalid cursor state&#8217; error.&nbsp; This allows deleting, inserting, and editing rows with Static and Keyset-Driven cursors to take place with no problems.</p>
Testing these problems with ASA 7.0 yielded some similar and some different results.&nbsp; Using the Forward-Only and Dynamic cursors, the &#8216;Fetch type out of range&#8217; errors that occurred with ASA 6.0 still occur with ASA 7.0.&nbsp; Using the Static and Keyset-Driven cursors with ASA 7.0, an error occurs when attempting to delete or update a row in the database.&nbsp; The error is, &#8216;Syntax error or access violation.&nbsp; Update operation attempted on non-updatable query.&#8217;  Also, when attempting to insert a row into the database, no error occurs but when you refresh the table, the row just added will disappear.&nbsp; These errors occur because of documented change in behavior from ASA 6.0.3 to ASA 7.0.&nbsp; To return to the behavior of ASA 6.0.3 the following can be done:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>From the Start Menu, click &#8216;Run&#8217;.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Type in &#8216;dbisql -c “uid=dba;pwd=sql;dsn=the name of your ODBC source&#8217; and click &#8216;OK&#8217;.&nbsp; For example, for the DelphiDemo you would type:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr></table></div>  dbisql -c "uid=dba;pwd=sql;dsn=DelphiDemo"</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>In the &#8216;SQL Statements&#8217; window type,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr></table></div> set option public.ansi_update_constraints=&#8216;off&#8217;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; and click the play button.</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">4.</td><td>When dbisql is finished executing the statement just typed in will be highlighted in blue.&nbsp; Exit dbisql.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">5.</td><td>Close down your Delphi application and restart it.&nbsp; Make sure the database engine shuts down and restarts.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">6.</td><td>You should now be able to insert, delete and update rows without problems, using a Static or Keyset_Driven cursor.&nbsp;</td></tr></table></div>&nbsp;</p>
Using the component &#8216;OEQuery&#8217; instead of &#8216;OEDataSet&#8217; makes very little difference.&nbsp; The two components are practically the same with only minor differences.&nbsp; When using the &#8216;OEQuery&#8217; components with a &#8216;DBGrid&#8217; component the same errors arise as when using the &#8216;OEDataSet&#8217; component.&nbsp; It should be noted that when a query is done involving more than one table, ODBCExpress cannot handle having two identical column names in both tables.&nbsp; Aliases for the column names must be placed in the SQL Select Statement if selecting two columns with the same name is to be done.&nbsp; Also, inserting rows, deleting rows or editing rows in a result set involving two or more tables falls outside the scope of this paper.</p>
&nbsp;</p>
Titan SQLAnywhere Developer</p>
To use a &#8216;DBGrid&#8217; component with Titan SQLAnywhere Developer, the BDE &#8216;DataSource&#8217; component must be present, and its &#8216;DataSet&#8217; property must be bound to a &#8216;tsTable&#8217; component or &#8216;tsQuery&#8217; component.&nbsp; This way the &#8216;DBGrid&#8217; component has a way of communicating with the database.&nbsp; Similar to the BLOB examples, syntax for using &#8216;DBGrid&#8217; and Titan is almost identical to using &#8216;DBGrid&#8217; with BDE.&nbsp; Unlike BDE and ODBCExpress, Titan SQLAnywhere Developer does not create the &#8216;Access violation at address 1F4ADCD4.&nbsp; Read of address 1F4ADCD4&#8217; error when the &#8216;Active&#8217; property is set to &#8216;True&#8217; and Delphi is closed.&nbsp;</p>
&nbsp;</p>
One of the only problems found when using Titan SQLAnywhere Developer with a &#8216;DBGrid&#8217; component is viewing the data in a particular order.&nbsp; Recall that with BDE, setting the &#8216;IndexFieldNames&#8217; property for the &#8216;TTable&#8217; component to a column in the table puts an ORDER BY clause on the end of the fetch and therefore returns a result set with the rows ordered by that column.&nbsp; When this is done using Titan&#8217;s &#8216;tsTable&#8217; component, the error &#8216;tsTable1 has no index for fields id&#8217; occurs where &#8216;id&#8217; is the name of the column that the &#8216;IndexFieldNames&#8217; was set to.&nbsp; There does not appear to be a way of viewing a result set in a particular order using a &#8216;tsTable&#8217; component.</p>
&nbsp;</p>
Using a &#8216;tsQuery&#8217; component instead of a &#8216;tsTable&#8217; component with a &#8216;DBGrid&#8217; is recommended when ordering data is necessary.&nbsp; With the &#8216;tsQuery&#8217;, the &#8216;SQL&#8217; property can be set so that many different SQL statements can be run on the database, leading to greater flexibility for viewing data.&nbsp; Using this component, no problems occur with regards to editing the rows in the result set.&nbsp; Getting the result set for the query is fast, and jumping to the last row in the result set takes relatively little time compared to BDE.&nbsp; If the query being executed involves more than one table, then inserting rows, deleting rows, or editing rows in the result set cannot be done using typical methods.</p>
&nbsp;</p>
Again, with Titan, when any changes are made to the table, a Commit must be explicitly written.&nbsp; The reason for this is that the default value for committing data is set differently in Titan than in BDE or ODBCExpress.</p>
&nbsp;</p>
&nbsp;</p>
NativeDB for SQL Anywhere</p>
Similar to ODBCExpress, NativeDB does not have a &#8216;Table&#8217; component and instead uses an &#8216;AsaDataset&#8217; component.&nbsp; To bind the &#8216;DBGrid&#8217; with the &#8216;AsaDataset&#8217;, which is used to access your database, the BDE &#8216;DataSource&#8217; component is added to the form.&nbsp; Then set the &#8216;DataSource&#8217; to point to the &#8216;AsaDataset&#8217; and the &#8216;DBGrid&#8217; to point to the &#8216;DataSource&#8217; component.&nbsp; The &#8216;AsaDataset&#8217; component accesses a table through its &#8216;SQL&#8217; property.&nbsp; Therefore, instead of being limited to selecting all columns from only one table, an SQL statement can be written to access any columns of a table as well as multiple tables at once.&nbsp; The &#8216;SQL&#8217; property gives the &#8216;AsaDataset&#8217; component similar functionality to the ODBCExpress &#8216;OEDataSet&#8217; component, as well as BDE &#8216;Query&#8217; and Titan &#8216;tsQuery&#8217; components.&nbsp; As with BDE, the &#8216;Active&#8217; property for &#8216;AsaDataset&#8217; must be set to &#8216;True&#8217; to display a table in the &#8216;DBGrid&#8217;.&nbsp; Unlike BDE and ODBCExpress, NativeDB does not create the &#8216;Access violation at address 1F4ADCD4&#8217; error discussed above.&nbsp; Also, the &#8216;ReadOnly&#8217; property must be set to &#8216;False&#8217; in order to insert, delete or update rows in the result set.</p>
&nbsp;</p>
An interesting feature with NativeDB is its ability to position the &#8216;DBGrid&#8217; vertical scrollbar at the current and accurate row.&nbsp; BDE, ODBCExpress and Titan only support a three-state scrollbar, where the scroll thumb is either at the top, bottom or in the middle.</p>
&nbsp;</p>
&nbsp;</p>
&nbsp;</p>
&nbsp;</p>
&nbsp;</p>
&nbsp;</p>
APPENDIX A</p>
Setting up Delphi with the ODBCExpress Interface</p>
If you are creating your application using the BDE then no set up is necessary after setting up an ODBC data source for your database.&nbsp; If, however, you decided to use the ODBCExpress engine or Titan SQL Anywhere, you have a few more steps to take before starting in Delphi.</p>
&nbsp;</p>
For ODBCExpress, the first step is to open Delphi and uninstall older versions of ODBCExpress.&nbsp; To do this:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Select &#8216;Component&#8217; from the tool bar and click &#8216;Install Packages&#8217;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>In the &#8216;Design packages&#8217; list box select the ODBCExpress package and click the &#8216;Remove&#8217; button</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>Click &#8216;OK&#8217; to remove the package</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">4.</td><td>Select &#8216;Tools&#8217; from the tool bar and click &#8216;Environment Options&#8217;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">5.</td><td>Select the &#8216;Library&#8217; tab and remove any references to directories that contain ODBCExpress components from the &#8216;Library Path&#8217; edit box</td></tr></table></div>&nbsp;</p>
To install ODBCExpress:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Select &#8216;Component&#8217; from the tool bar and click &#8216;Install Packages&#8217; (Figure 12)</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Click on the &#8216;Add&#8217; button and select the file OE.bpl from the &#8216;Package&#8217; folder in the directory in which you unzipped ODBCExpress</td></tr></table></div>&nbsp;</p>
Figure 12</p>
<img src="/pic/clip0146.png" width="1024" height="768" border="0" alt="clip0146"></p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>Click &#8216;OK&#8217; to install the package</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">4.</td><td>Select &#8216;Tools&#8217; from the tool bar and click &#8216;Environment Options&#8217;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">5.</td><td>Select the &#8216;Library&#8217; tab</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">6.</td><td>In the &#8216;Library Path&#8217; edit box, add the path to the folders &#8216;Lib&#8217; and &#8216;Package&#8217;, which is where you unzipped ODBCExpress</td></tr></table></div>&nbsp;</p>
To install the help files:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Copy the help files &#8216;OE32.HLP&#8217; and &#8216;OE32.CNT&#8217; into the &#8216;Help&#8217; folder under the Delphi main directory</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Open the DELPHI3.CNT file located in the Delphi Help directory and add the line,</td></tr></table></div>  &nbsp; &nbsp; &nbsp; &nbsp;:Index ODBCExpress Reference=oe32.hlp,</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; to the &#8216;Index&#8217; section at the top of the file</p>
Note that for new versions this is done automatically.</p>
&nbsp;</p>
When these steps are done, start up Delphi and you should notice a new tab on the &#8216;Components&#8217; palette (the window located at the top of the screen) with the name ODBCExpress.&nbsp; Please refer to the Figure 13 below.&nbsp; Use these components instead of the provided BDE components to create applications with ODBCExpress capabilities.&nbsp; If you require help on the ODBCExpress data types or different functions and procedures you simply select &#8216;Help&#8217; from the tool bar and you can search for the information you are looking for.</p>
&nbsp;</p>
Figure 13</p>
<img src="/pic/clip0147.png" width="1019" height="107" border="0" alt="clip0147"></p>
&nbsp;</p>
These instructions can also be found in the Readme file that is included when you download ODBCExpress.</p>
&nbsp;</p>
&nbsp;</p>
APPENDIX B</p>
Modifying ASA 7.0 Sample</p>
The sample database that comes with ASA 7.0 is called asademo.db and is located in the directory you installed ASA in.&nbsp; By default this is C:\Program Files\Sybase\SQL Anywhere 7\asademo.db.&nbsp; First make a copy of asademo.db, and copy it to another directory and rename it.&nbsp; For this example the database was renamed asademoTest.&nbsp; Renaming the database should be done so you always have a fresh copy of the original database in case something goes wrong.&nbsp; The log file should also be renamed.&nbsp; The quickest way to do this is to click on &#8216;Start а Run&#8217; and type in &#8216;dblog &#8211;t C:\asademoTest.log C:\asademoTest.db&#8217;.&nbsp; Here, C:\asademoTest.log is the path and name of where you want the log file and what you want to call it.&nbsp; C:\asademoTest.db is the path and name of where the renamed database can be found.</p>
&nbsp;</p>
The simplest way to modify the database is to do the following:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Open &#8216;Sybase Central 4.0&#8217; by clicking &#8216;Start а Programs а Sybase SQL Anywhere 7 а Sybase Central 4.0&#8217;.&nbsp; When the window appears, you will notice that asademo can be seen on the left-hand side of your screen under the title Adaptive Server Anywhere 7.&nbsp; You should also notice a database engine icon in the bottom right-hand side of your screen on the Start bar</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>From the menu bar choose &#8216;Tools&#8217; and select &#8216;Connect&#8217;.&nbsp; A window called &#8216;New Connection&#8217; will appear.&nbsp; Choose &#8216;Adaptive Server Anywhere 7 from the drop down menu and click &#8216;OK&#8217;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>On the &#8216;Identification&#8217; tab type in the &#8216;User&#8217; as &#8216;dba&#8217; in the appropriate edit box and the &#8216;Password&#8217; as &#8216;sql&#8217; in its edit box</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">4.</td><td>On the &#8216;Database&#8217; tab click on the &#8216;Browse&#8217; button located by &#8216;Database File&#8217;.&nbsp; Find the path where you placed your copy of asademo.db and select your database (e.g.&nbsp; C:\asademoTest.db )</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">5.</td><td>Click &#8216;OK&#8217;.&nbsp;&nbsp; It will appear as if nothing happened but if you click on the &#8216;+&#8217; to the left of asademo, you should see the name of your database (in this case asademoTest) as well as asademo with a different icon</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">6.</td><td>Click on the &#8216;+&#8217; to the left of asademoTest and you will see a list of folders, the top one being &#8216;Tables&#8217;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">7.</td><td>If you click on the &#8216;+&#8217; to the left of the &#8216;Tables&#8217; folder you will see a list of all the names of the tables in the database.&nbsp; Figure 14 on the following page depicts what you should see at this point</td></tr></table></div>&nbsp;</p>
&nbsp;</p>
&nbsp;</p>
Figure 14</p>
<img src="/pic/clip0148.png" width="1024" height="768" border="0" alt="clip0148"></p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">8.</td><td>If you want to add a table, click on the &#8216;Tables&#8217; folder and on the right hand side double click on &#8216;Add Table&#8217;.&nbsp; This will bring you to a form where you can name the table and add columns to it.&nbsp; Note that this is not a way of putting information into the table.&nbsp; It is just a way of creating the names of the columns</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">9.</td><td>If you want to modify data in an existing table, right click on the name of the table you wish to modify and select &#8216;View Data&#8217;.&nbsp; This will bring up a window named &#8216;Interactive SQL&#8217;, which contains three sections.&nbsp; The first section, labeled &#8216;SQL Statements&#8217; contains the command line &#8216;SELECT * FROM "DBA"."department"&#8217;, where department is the name of the table you chose. The middle section, labeled &#8216;Messages&#8217;, will be blank.&nbsp; The last section is labeled &#8216;Results&#8217; and contains a list of the column headers and all the information that is associated with it.</td></tr></table></div>&nbsp;</p>
Figure 15 below displays &#8216;Interactive SQL&#8217; when the &#8216;View Data&#8217; option is selected on the &#8216;department&#8217; table.</p>
&nbsp;</p>
&nbsp;</p>
Figure 15</p>
<img src="/pic/clip0149.png" width="925" height="670" border="0" alt="clip0149"></p>
&nbsp;</p>
To insert a new row, use the following command and then click the play button: INSERT INTO department VALUES ('600', 'HR', '501');.&nbsp; Note that &#8216;department&#8217; is the name of the table that you are inserting values into and the values in brackets must correspond to the columns in the table.&nbsp; There must be a value for every column in the table otherwise an error will occur.&nbsp; Also, the values entered must correspond to the type assigned to that column.&nbsp; To delete rows from the table enter the following line in the command section and click on the play button: DELETE FROM department WHERE dept_id=600;.&nbsp; Note that this command not only deletes every column in the row where dept_id (a column in the table department) equals 600, but it also deletes every row in the table where dept_id equals 600</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">10.</td><td>When you are done modifying a table, close the &#8216;Interactive SQL&#8217; window.&nbsp; This will bring you back to &#8216;Sybase Central&#8217; where you can modify more tables.&nbsp; If you are finished modifying asademoTest, click on &#8216;Tools&#8217; from the menu bar and select &#8216;Disconnect&#8217;.&nbsp; A window will pop up and you should select asademoTest and click &#8216;Disconnect&#8217;.&nbsp; Then you can close &#8216;Sybase Central&#8217;</td></tr></table></div>&nbsp;</p>
&nbsp;</p>
&nbsp;</p>
APPENDIX C</p>
&nbsp;</p>
Primary Key Issues</p>
Adaptive Server Anywhere is a SQL relational database.&nbsp; Many designers using this technology adhere to the Third Normal Form design practices.&nbsp; These practices utilize the primary key definition.&nbsp; A primary key (or unique index) is a column or combination of columns that can be used to uniquely identify each row in the table, meaning that no two rows in a table may have the same value for the primary key column(s).&nbsp; For this reason, using a column whose data type is &#8216;integer&#8217; and whose default is &#8216;autoincrement&#8217;, is common for a primary key.&nbsp;</p>
&nbsp;</p>
In the section BLOB Examples (page 10), the column &#8216;keyfld&#8217;, for the table &#8216;blob&#8217;, is the primary key and has the integer data type and default autoincrement.&nbsp; When inserting a blob into the table using ISQL, a value for the column &#8216;keyfld&#8217; can be omitted because of its default.&nbsp; Autoincrement will provide a unique value for the newly inserted row.&nbsp; In Delphi this is not the case and therefore a value must be supplied for the &#8216;keyfld&#8217; column.&nbsp; There are several ways in which this value can be supplied, however, only the fourth method described can guarantee that problems will not arise.&nbsp;</p>
&nbsp;</p>
One method for providing a value for the &#8216;keyfld&#8217; column is used in Example 1, and Example 3.&nbsp; A variable called nextnum is created and is assigned a value by the following two lines of code.&nbsp; For Example 1 they are:</p>
 &nbsp; &nbsp; &nbsp; &nbsp;Table1.Last;</p>
 &nbsp; &nbsp; &nbsp; &nbsp;nextnum := Table1.FieldByName(&#8216;keyfld&#8217;).asInteger + 1;</p>
For Example 3 they are:</p>
 &nbsp; &nbsp; &nbsp; &nbsp;OEDataSet1.Last;</p>
nextnum := OEDataSet1.FieldValues[&#8216;keyfld&#8217;] + 1;</p>
These lines of code are jumping to the last row in the table, and assigning nextnum the value that is in the &#8216;keyfld&#8217; column currently plus one.&nbsp; Nextnum is then used as the value for the &#8216;keyfld&#8217; column when the new row is inserted.&nbsp; This seems like it would be a good method for finding a value for &#8216;keyfld&#8217;, however a problem can arise.&nbsp; Doing an &#8216;Insert&#8217; on a table does not guarantee that this row will be added to the end of the table.&nbsp; Therefore, the last row in the table may not hold the highest value for the &#8216;keyfld&#8217; column and as a result nextnum has the chance of being assigned a value that already exists in the table.&nbsp; If this happens, then the error &#8216;Primary key for blob is not unique&#8217; will be given when the insert is executed.</p>
&nbsp;</p>
Another method for providing a value for the &#8216;keyfld&#8217; column is one that will get you around the error discussed in the paragraph above.&nbsp; Instead of using &#8216;Insert&#8217; to add a new row into the table, use the Append method.&nbsp; When the Append method is called, it always inserts a new row at the bottom of the table.&nbsp; Then the two lines of code discussed above can be used to find a unique value for the &#8216;keyfld&#8217; column.&nbsp; This method will work provided that the table has no rows to start or it is known for certain that the rows currently in the table are already in order.&nbsp; Problems with this method may also arise if more then one person is adding to the table at a time.</p>
&nbsp;</p>
A third method for supplying a value for the &#8216;keyfld&#8217; column is to use a property called &#8216;RecordCount&#8217;.&nbsp; This property, when used properly, will give a count of the number of records in a result set.&nbsp; If the result set is the entire table then this method is useful for getting a value for &#8216;keyfld&#8217;.&nbsp; To get this value properly, a jump to the last record in the table must occur.&nbsp; For the BDE, the lines of code to accomplish this task would look like this.</p>
 &nbsp; &nbsp; &nbsp; &nbsp;Table1.Last&nbsp; // To jump to the last row in the table</p>
 &nbsp; &nbsp; &nbsp; &nbsp;nextnum := Table1.RecordCount + 1;</p>
The major concern with using this method is that the values in the &#8216;keyfld&#8217; column must start at 1, and have no numbers missing from 1 to the last value.&nbsp; The reason is because of the way ASA deals with deleting a row which has a column with the autoincrement default.&nbsp; A simple example will illustrate how ASA accomplishes deleting a row which has a column with the autoincrement default.&nbsp; If there are five rows in a table, say 1, 2, 3, 4, 5, and rows 4 and 5 are deleted, rows 1, 2, and 3 remain.&nbsp; If a new row is added now and autoincrement supplies a value, that value will be 6.&nbsp; So, if the values for the &#8216;keyfld&#8217; column are missing numbers or do not start with 1, then the number of rows in the table (which the RecordCount property provides) will not be representative of the next value, which should be placed in the &#8216;keyfld&#8217; column.&nbsp; This could lead to a duplicate value for the primary key, which is not allowed.&nbsp;</p>
&nbsp;</p>
The method that is recommended for providing a value for the column &#8216;keyfld&#8217;, is to get Delphi to recognize that a value is not required on the ASA end where the default is autoincrement.&nbsp; The line of code that can accomplish this for BDE is:</p>
 &nbsp; &nbsp; &nbsp; &nbsp;Table1.Fields[0].Required := False;</p>
For ODBCExpress the line of code would be:</p>
 &nbsp; &nbsp; &nbsp; &nbsp;OEDataSet1.Fields[0].Required := False;</p>
For Titan SQLAnywhere Developer the line of code would be:</p>
 &nbsp; &nbsp; &nbsp; &nbsp;tsTable1.Fields[0].Required := False;</p>
It should be noted that Delphi represents columns in a table through numbers starting at 0.&nbsp; In the lines of code above, it is assumed that the column 0 is the column with the default autoincrement.&nbsp; More details on where this line of code can be implemented are included the section DBGrid Examples on page 18 where autoincrement is discussed.</p>
&nbsp;</p>
&nbsp;</p>
&nbsp;</p>
APPENDIX D</p>
The table below is of all the products and their versions used to discover the problems and solutions discussed in this paper.&nbsp; It should be noted that the ebf for ASA discussed in the section DBGrid Examples on page 25 has the build number 2934</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td>
</td>
<td><p>ASA</p>
</td>
<td><p>BDE</p>
</td>
<td><p>ODBCExpress</p>
</td>
<td><p>Titan</p>
</td>
<td><p>NativeDB</p>
</td>
</tr>
<tr>
<td><p>Delphi 3 Client/Server Suite&nbsp; Versions used</p>
</td>
<td><p>6.0.3.2747</p>
<p>7.0.0.313</p>
</td>
<td><p>4.0</p>
</td>
<td><p>4.53</p>
</td>
<td><p>3.02p</p>
</td>
<td><p>1.84</p>
</td>
</tr>
<tr>
<td><p>Delphi 5 Enterprise&nbsp; Versions used</p>
</td>
<td><p>6.0.3.2747</p>
<p>7.0.0.313</p>
</td>
<td><p>5.1.0.4</p>
</td>
<td><p>5.05</p>
</td>
<td><p>5</p>
</td>
<td><p>1.84
</td>
</tr>
</table>
More information about the interfaces discussed in this document can be found on their respective web pages:</p>
&nbsp;</p>
BDE: http://www.borland.com/delphi</p>
ODBCExpress: http://www.odbcexpress.com</p>
Titan SQL Anywhere Developer: http://www.reggatta.com/sqadev.html</p>
NativeDB: http://www.nativedb.com</p>

