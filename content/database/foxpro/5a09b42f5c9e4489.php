<h1>Ограничения Foxpro</h1>
<div class="date">01.01.2007</div>



<p>Table and Index Files</p>
<p>Max. # of records per table &mdash; 1 billion*</p>
<p>Max. # of chars per record &mdash; 65,000</p>
<p>Max. # of fields per record &mdash; 255</p>
<p>Max. # of open DBFs &mdash; &nbsp;225</p>
<p>Max. # of chars per field &mdash; 254</p>
<p>Max. # of chars per index key (IDX)&nbsp;100</p>
<p>Max. # of chars per index key (CDX)&nbsp;240</p>
<p>Max. # of open index files per table&nbsp;unlimited**</p>
<p>Max. # of open index files in all work areas&nbsp;unlimited**</p>
<p>* The actual file size (in bytes) cannot exceed 2 gigabytes for single-user or exclusively opened multi-user tables. Shared tables with no indexes or .IDX indexes cannot exceed 1 gigabyte. Shared tables with structural .CDX indexes cannot exceed 2 gigabytes.</p>
<p>** Limited by memory. In FoxPro for MS-DOS and FoxPro for Windows, also limited by available MS-DOS file handles. Each .CDX file uses only 1 file handle. The number of MS-DOS file handles is determined by the CONFIG.SYS FILES parameter.</p>

<p>Field Characteristics</p>
<p>Max. size of character fields &mdash; 254</p>
<p>Max. size of numeric fields &mdash; &nbsp;20</p>
<p>Max. # of chars in field names &mdash; 10</p>
<p>Digits of precision in numeric computations&nbsp;16</p>
<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
