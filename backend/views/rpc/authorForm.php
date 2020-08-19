<?php
declare(strict_types=1);

/**
 * @var array $fields
 */
?>
<div class="container" style="width:60%">
  <table class="table">
    <thead>
    <tr>
      <th>
        <h3>Name</h3>
      </th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td>First name</td>
      <td>
        <input type="text" name="name" style="width: 145px; padding: 1px" value="{{ name }}">
      </td>
      <td>Middle name</td>
      <td>
        <input type="text" name="middleName" style="width: 45px; padding: 1px" value="{{ middleName }}">
      </td>
      <td>Last name</td>
      <td>
        <input type="text" name="lastName" style="width: 145px; padding: 1px" value="{{ lastName }}">
      </td>
    </tr>
    </tbody>
  </table>
  <table class="table">
    <thead>
    <tr>
      <th>
        <h3>Biography</h3>
      </th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td>
        <textarea name="biography" style="width: 100%; padding: 1px">{{ biography }}</textarea>
      </td>
    </tr>
    </tbody>
  </table>
</div>
<input type="hidden" name="pageUid" value="<?= $fields['pageUid'] ?>">
<input type="hidden" name="formType" value="<?= $fields['formType'] ?>">
