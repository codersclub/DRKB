<h1>How to debug an Apache Shared Module</h1>
<div class="date">01.01.2007</div>


<p>I am running Apache on Windows and want to know how to debug Apache Shared Modules? </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; It is a straight forward task to debug Shared Modules in Delphi. The only thing that needs to be done is to set the Host Application and Parameters for the Shared Module's Project. From the Delphi menu bar go to Run | Parameters. Set the Host Application to point to Apache.exe, and specify the following parameters: -X -w -f "c:\path tohttpd.conf". </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; When you run the project be sure that IIS is not running. If you need IIS to run while Apache is running then change the Port value stored in httpd.conf.</p>
