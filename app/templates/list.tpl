{extends file='layout.tpl'}

{block name=page}

<ul class="menuleft">
  {foreach $list as $v}
    <li>
      {if $v eq $current}
        <span style="font-weight:bold">{$v}</span>
        {else}
        <a href="{$LURL}/contact/{$v}">{$v}</a>
      {/if}
    </li>
  {/foreach}
</ul>

  {text key=$page|cat:'_'|cat:$current}

{/block}