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
        <h3>Title</h3>
      </th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td>
        <input type="text" name="title" style="width: 100%; padding: 1px" value="{{ title }}">
      </td>
    </tr>
    </tbody>
  </table>
  <table class="table">
    <thead>
    <tr>
      <th>
        <h3>Review</h3>
      </th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td>
        <textarea name="review" style="width: 100%; padding: 1px">{{ review }}</textarea>
      </td>
    </tr>
    </tbody>
  </table>
</div>
<input type="hidden" name="pageUid" value="<?= $fields['pageUid'] ?>">
<input type="hidden" name="formType" value="<?= $fields['formType'] ?>">
