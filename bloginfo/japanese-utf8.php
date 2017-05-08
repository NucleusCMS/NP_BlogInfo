<?php
define('_BLOGINFO_Description','
1, 引数に[id][short][name][desc][url]を指定し、標準のスキン変数<%blogsetting%>と同様の機能をスキン及びテンプレートで実現。<br />
- 記述例 : <%BlogInfo(id)%><br />
2, 第2引数でblogidを指定し、そのidのブログの[id][short][name][desc][url]を表示。<br />
- 記述例 : <%BlogInfo(id,3)%><br />
3, 第2引数にmemberidを指定し、そのidのメンバーの[name][realname][notes][url][email][id]を表示。尚、[name]らを第1引数に指定する際には、頭に[m]を付け[mname]とする事。<br />
- 記述例 : <%BlogInfo(mname,1)%>
');
?>