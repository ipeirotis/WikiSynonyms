<div class="page-header">
  <h1>API</h1>
</div>
<div class="row">
  <div class="span12">
    <strong>Url:</strong> http://wikisynonyms.ipeirotis.com/api/ <code>{term} </code><br/>
    <strong>Method:</strong>  <code>GET </code><br/>
    <strong>Params:</strong> {term}: String<br/>
    <strong>Responce:</strong> <br/>
    <pre>
{http: status code, message: status message, terms: [Array of terms]}
    </pre>
    <strong>Example:</strong> c++<br/>
    <code>http://wikisynonyms.ipeirotis.com/api/c%2B%2B</code><br/>
    <h5>Reference for terms result:</h5>
    <strong>term</strong> (string): synonym name <br/>
    <strong>canonical</strong> (boolean): marks if synonym is a canonical wikipedia page (-no redirect)<br/>
    <strong>oskill</strong> (boolean): marks if synonym is a wikipedia page used in odesk skills<br/><br/>
    <pre>
{
  http: 200,
  message: "success",
  terms: [
    {
      term: "C++",
      canonical: 1,
      oskill: 0
    },
    {
      term: "C plus plus programming language",
      canonical: 0,
      oskill: 0
    },
    {
      term: "C Plus Plus programming language",
      canonical: 0,
      oskill: 0
    },
    {
      term: "Cplusplus",
      canonical: 0,
      oskill: 0
    },
    {
      term: "ISO/IEC 14882",
      canonical: 0,
      oskill: 0
    },
    {
      term: "CPlusPlus",
      canonical: 0,
      oskill: 0
    },
    {
      term: "C with classes",
      canonical: 0,
      oskill: 0
    },
    {
      term: "C-plus-plus programming language",
      canonical: 0,
      oskill: 0
    },
    {
      term: "C Plus Plus",
      canonical: 0,
      oskill: 0
    },
    {
      term: "C plus plus",
      canonical: 0,
      oskill: 0
    },
    {
      term: "C-plus-plus",
      canonical: 0,
      oskill: 0
    },
    {
      term: "C==",
      canonical: 0,
      oskill: 0
    },
    {
      term: "C++ (programming language)",
      canonical: 0,
      oskill: 0
    },
    {
      term: "C++ programming language",
      canonical: 0,
      oskill: 0
    },
    {
      term: "ISO/IEC 14882:2003",
      canonical: 0,
      oskill: 0
    },
    {
      term: "C++ syntax",
      canonical: 0,
      oskill: 0
    },
    {
      term: "Cee plus plus",
      canonical: 0,
      oskill: 0
    },
    {
      term: "Cee Plus Plus",
      canonical: 0,
      oskill: 0
    },
    {
      term: "++C",
      canonical: 0,
      oskill: 0
    },
    {
      term: "ISO 14882",
      canonical: 0,
      oskill: 0
    },
    {
      term: "Cxx",
      canonical: 0,
      oskill: 0
    },
    {
      term: ".cxx",
      canonical: 0,
      oskill: 0
    },
    {
      term: "ANSI C++",
      canonical: 0,
      oskill: 0
    },
    {
      term: "C++98",
      canonical: 0,
      oskill: 0
    },
    {
      term: "C+++",
      canonical: 0,
      oskill: 0
    },
    {
      term: "Criticism of C++",
      canonical: 0,
      oskill: 0
    },
    {
      term: "ISO C++ programming language",
      canonical: 0,
      oskill: 0
    },
    {
      term: "Gxavo",
      canonical: 0,
      oskill: 0
    },
    {
      term: "Export (C++)",
      canonical: 0,
      oskill: 0
    },
    {
      term: "ISO C++",
      canonical: 0,
      oskill: 0
    },
    {
      term: "C with Classes",
      canonical: 0,
      oskill: 0
    },
    {
      term: "CXX",
      canonical: 0,
      oskill: 0
    },
    {
      term: "Sepples",
      canonical: 0,
      oskill: 0
    },
    {
      term: "C++ program",
      canonical: 0,
      oskill: 0
    },
    {
      term: "C++ standard",
      canonical: 0,
      oskill: 0
    },
    {
      term: "C++ language",
      canonical: 0,
      oskill: 0
    },
    {
      term: "X3J16",
      canonical: 0,
      oskill: 0
    }
  ]
}
    </pre>
  </div>
</div>