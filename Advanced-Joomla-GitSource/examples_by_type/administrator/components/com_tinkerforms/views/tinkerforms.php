<?php
/**
 * @version		$Id: tinkerforms.php 10149 2008-03-19 10:42:39Z eddieajau $
 * @package		Joomla
 * @subpackage	Tinkerformss
 * @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
* @package		Joomla
* @subpackage	Tinkerforms tinkerformsViewtinkerforms TinkerFormsViewTinkerforms
*/
class tinkerformsViewtinkerforms
{
	function setTinkerFormsToolbar()
	{
		JToolBarHelper::title( JText::_( 'TinkerForms Manager' ), 'generic.png' );
		JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();
		JToolBarHelper::customX( 'copy', 'copy.png', 'copy_f2.png', 'Copy' );
		JToolBarHelper::deleteList();
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();
		JToolBarHelper::preferences('com_tinkerforms', '200');
		JToolBarHelper::help( 'screen.tinkerformss' );
	}

	function tinkerforms( &$rows, &$pageNav, &$lists )
	{
		TinkerformssViewTinkerforms::setTinkerFormsToolbar();
		$user =& JFactory::getUser();
		JHTML::_('behavior.tooltip');
		?>
		<form action="index.php?option=com_tinkerforms" method="post" name="adminForm">
		<table>
		<tr>
			<td align="left" width="100%">
				<?php echo JText::_( 'Filter' ); ?>:
				<input type="text" name="search" id="search" value="<?php echo $lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
				<button onclick="document.getElementById('search').value='';this.form.getElementById('filter_catid').value='0';this.form.getElementById('filter_state').value='';this.form.submit();"><?php echo JText::_( 'Filter Reset' ); ?></button>
			</td>
			<td nowrap="nowrap">
				<?php
				echo $lists['catid'];
				echo $lists['state'];
				?>
			</td>
		</tr>
		</table>

			<table class="adminlist">
			<thead>
				<tr>
					<th width="20">
						<?php echo JText::_( 'Num' ); ?>
					</th>
					<th width="20">
						<input type="checkbox" name="toggle" value=""  onclick="checkAll(<?php echo count( $rows ); ?>);" />
					</th>
					<th nowrap="nowrap" class="title">
						<?php echo JHTML::_('grid.sort',  'Name', 'b.name', @$lists['order_Dir'], @$lists['order'] ); ?>
					</th>
					<th width="10%" nowrap="nowrap">
						<?php echo JHTML::_('grid.sort',   'Client', 'c.name', @$lists['order_Dir'], @$lists['order'] ); ?>
					</th>
					<th width="10%" nowrap="nowrap">
						<?php echo JHTML::_('grid.sort',   'Category', 'cc.title', @$lists['order_Dir'], @$lists['order'] ); ?>
					</th>
					<th width="5%" nowrap="nowrap">
						<?php echo JHTML::_('grid.sort',   'Published', 'b.showTinkerforms', @$lists['order_Dir'], @$lists['order'] ); ?>
					</th>
					<th width="8%" nowrap="nowrap">
						<?php echo JHTML::_('grid.sort',   'Order', 'b.ordering', @$lists['order_Dir'], @$lists['order'] ); ?>
						<?php echo JHTML::_('grid.order',  $rows ); ?>
					</th>
					<th width="5%" nowrap="nowrap">
						<?php echo JHTML::_('grid.sort',   'Sticky', 'b.Sticky', @$lists['order_Dir'], @$lists['order'] ); ?>
					</th>
					<th width="5%" nowrap="nowrap">
						<?php echo JHTML::_('grid.sort',   'Impressions', 'b.impmade', @$lists['order_Dir'], @$lists['order'] ); ?>
					</th>
					<th width="80">
						<?php echo JHTML::_('grid.sort',   'Clicks', 'b.clicks', @$lists['order_Dir'], @$lists['order'] ); ?>
					</th>
					<th width="5%" nowrap="nowrap">
						<?php echo JText::_( 'Tags' ); ?>
					</th>
					<th width="1%" nowrap="nowrap">
						<?php echo JHTML::_('grid.sort',   'ID', 'b.bid', @$lists['order_Dir'], @$lists['order'] ); ?>
					</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="13">
						<?php echo $pageNav->getListFooter(); ?>
					</td>
				</tr>
			</tfoot>
			<tbody>
			<?php
			$k = 0;
			for ($i=0, $n=count( $rows ); $i < $n; $i++) {
				$row = &$rows[$i];

				$row->id	= $row->bid;
				$link		= JRoute::_( 'index.php?option=com_tinkerforms&task=edit&cid[]='. $row->id );

				if( $row->imptotal <= 0 ) {
					$row->imptotal	=  JText::_('unlimited');
				}

				if ( $row->impmade != 0 ) {
					$percentClicks = 100 * $row->clicks/$row->impmade;
				} else {
					$percentClicks = 0;
				}

				$row->published = $row->showTinkerforms;
				$published		= JHTML::_('grid.published', $row, $i );
				$checked		= JHTML::_('grid.checkedout',   $row, $i );
				?>
				<tr class="<?php echo "row$k"; ?>">
					<td align="center">
						<?php echo $pageNav->getRowOffset($i); ?>
					</td>
					<td align="center">
						<?php echo $checked; ?>
					</td>
					<td>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'Edit' );?>::<?php echo $row->name; ?>">
						<?php
						if ( JTable::isCheckedOut($user->get ('id'), $row->checked_out ) ) {
							echo $row->name;
						} else {
							?>

							<a href="<?php echo $link; ?>">
								<?php echo $row->name; ?></a>
							<?php
						}
						?>
						</span>
					</td>
					<td align="center">
						<?php echo $row->client_name;?>
					</td>
					<td align="center">
						<?php echo $row->category_name;?>
					</td>
					<td align="center">
						<?php echo $published;?>
					</td>
					<td class="order">
						<input type="text" name="order[]" size="5" value="<?php echo $row->ordering;?>" class="text_area" style="text-align: center" />
					</td>
					<td align="center">
						<?php echo $row->sticky ? JText::_( 'Yes' ) : JText::_( 'No' );?>
					</td>
					<td align="center">
						<?php echo $row->impmade.' '.JText::_('of').' '.$row->imptotal?>
					</td>
					<td align="center">
						<?php echo $row->clicks;?> -
						<?php echo sprintf( '%.2f%%', $percentClicks );?>
					</td>
					<td>
						<?php echo $row->tags; ?>
					</td>
					<td align="center">
						<?php echo $row->id; ?>
					</td>
				</tr>
				<?php
				$k = 1 - $k;
			}
			?>
			</tbody>
			</table>

		<input type="hidden" name="c" value="tinkerforms" />
		<input type="hidden" name="option" value="com_tinkerforms" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $lists['order_Dir']; ?>" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
		<?php
	}

	function setTinkerformsToolbar()
	{
		$task = JRequest::getVar( 'task', '', 'method', 'string');

		JToolBarHelper::title( $task == 'add' ? JText::_( 'Tinkerforms' ) . ': <small><small>[ '. JText::_( 'New' ) .' ]</small></small>' : JText::_( 'Tinkerforms' ) . ': <small><small>[ '. JText::_( 'Edit' ) .' ]</small></small>', 'generic.png' );
		JToolBarHelper::save( 'save' );
		JToolBarHelper::apply('apply');
		JToolBarHelper::cancel( 'cancel' );
		JToolBarHelper::help( 'screen.tinkerformss.edit' );
	}

	function tinkerforms( &$row, &$lists )
	{
		TinkerformssViewTinkerforms::setTinkerformsToolbar();
		JRequest::setVar( 'hidemainmenu', 1 );
		JFilterOutput::objectHTMLSafe( $row, ENT_QUOTES, 'customtinkerformscode' );
		?>
		<script language="javascript" type="text/javascript">
		<!--
		function changeDisplayImage() {
			if (document.adminForm.imageurl.value !='') {
				document.adminForm.imagelib.src='../images/tinkerformss/' + document.adminForm.imageurl.value;
			} else {
				document.adminForm.imagelib.src='images/blank.png';
			}
		}
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}
			// do field validation
			if (form.name.value == "") {
				alert( "<?php echo JText::_( 'You must provide a tinkerforms name.', true ); ?>" );
			} else if (getSelectedValue('adminForm','cid') < 1) {
				alert( "<?php echo JText::_( 'Please select a client.', true ); ?>" );
			/*} else if (!getSelectedValue('adminForm','imageurl')) {
				alert( "<?php echo JText::_( 'Please select an image.', true ); ?>" );*/
			/*} else if (form.clickurl.value == "") {
				alert( "<?php echo JText::_( 'Please fill in the URL for the tinkerforms.', true ); ?>" );*/
			} else if ( getSelectedValue('adminForm','catid') == 0 ) {
				alert( "<?php echo JText::_( 'Please select a category.', true ); ?>" );
			} else {
				submitform( pressbutton );
			}
		}
		//-->
		</script>
		<form action="index.php" method="post" name="adminForm">

		<div class="col100">
			<fieldset class="adminform">
				<legend><?php echo JText::_( 'Details' ); ?></legend>

				<table class="admintable">
				<tbody>
					<tr>
						<td width="20%" class="key">
							<label for="name">
								<?php echo JText::_( 'Name' ); ?>:
							</label>
						</td>
						<td width="80%">
							<input class="inputbox" type="text" name="name" id="name" size="50" value="<?php echo $row->name;?>" />
						</td>
					</tr>
					<tr>
						<td width="20%" class="key">
							<label for="alias">
								<?php echo JText::_( 'Alias' ); ?>:
							</label>
						</td>
						<td width="80%">
							<input class="inputbox" type="text" name="alias" id="alias" size="50" value="<?php echo $row->alias;?>" />
						</td>
					</tr>
					<tr>
						<td class="key">
							<?php echo JText::_( 'Show Tinkerforms' ); ?>:
						</td>
						<td>
							<?php echo $lists['showTinkerforms']; ?>
						</td>
					</tr>
					<tr>
						<td class="key">
							<?php echo JText::_( 'Sticky' ); ?>:
						</td>
						<td>
							<?php echo $lists['sticky']; ?>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="ordering">
								<?php echo JText::_( 'Ordering' ); ?>:
							</label>
						</td>
						<td>
							<input class="inputbox" type="text" name="ordering" id="ordering" size="6" value="<?php echo $row->ordering;?>" />
						</td>
					</tr>
					<tr>
						<td valign="top" align="right" class="key">
							<label for="catid">
								<?php echo JText::_( 'Category' ); ?>:
							</label>
						</td>
						<td>
							<?php echo $lists['catid']; ?>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="cid">
								<?php echo JText::_( 'Client Name' ); ?>:
							</label>
						</td>
						<td >
							<?php echo $lists['cid']; ?>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="imptotal">
								<?php echo JText::_( 'Impressions Purchased' ); ?>:
							</label>
						</td>
						<?php
						$unlimited = '';
						if ($row->imptotal == 0) {
							$unlimited = 'checked="checked"';
							$row->imptotal = '';
						}
						?>
						<td>
							<input class="inputbox" type="text" name="imptotal" id="imptotal" size="12" maxlength="11" value="<?php echo $row->imptotal;?>" />
							&nbsp;&nbsp;&nbsp;&nbsp;
							<label for="unlimited">
								<?php echo JText::_( 'Unlimited' ); ?>
							</label>
							<input type="checkbox" name="unlimited" id="unlimited" <?php echo $unlimited;?> />
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="clickurl">
								<?php echo JText::_( 'Click URL' ); ?>:
							</label>
						</td>
						<td>
							<input class="inputbox" type="text" name="clickurl" id="clickurl" size="100" maxlength="200" value="<?php echo $row->clickurl;?>" />
						</td>
					</tr>
					<tr >
						<td valign="top" align="right" class="key">
							<?php echo JText::_( 'Clicks' ); ?>:
						</td>
						<td colspan="2">
							<?php echo $row->clicks;?>
							&nbsp;&nbsp;&nbsp;&nbsp;
							<input name="reset_hits" type="button" class="button" value="<?php echo JText::_( 'Reset Clicks' ); ?>" onclick="submitbutton('resethits');" />
						</td>
					</tr>
					<tr>
						<td valign="top" class="key">
							<label for="customtinkerformscode">
								<?php echo JText::_( 'Custom tinkerforms code' ); ?>:
							</label>
						</td>
						<td>
							<textarea class="inputbox" cols="70" rows="8" name="customtinkerformscode" id="customtinkerformscode"><?php echo $row->customtinkerformscode;?></textarea>
						</td>
					</tr>
					<tr>
						<td valign="top" class="key">
							<label for="description">
								<?php echo JText::_( 'Description/Notes' ); ?>:
							</label>
						</td>
						<td>
							<textarea class="inputbox" cols="70" rows="3" name="description" id="description"><?php echo $row->description;?></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="3">
						</td>
					</tr>
					<tr>
						<td valign="top" class="key">
							<label for="imageurl">
								<?php echo JText::_( 'Tinkerforms Image Selector' ); ?>:
							</label>
						</td>
						<td >
							<?php echo $lists['imageurl']; ?>
						</td>
					</tr>
					<tr>
						<td valign="top" class="key">
							<?php echo JText::_( 'Tinkerforms Image' ); ?>:
						</td>
						<td valign="top">
							<?php
							if (eregi("swf", $row->imageurl)) {
								?>
								<img src="images/blank.png" name="imagelib">
								<?php
							} elseif (eregi("gif|jpg|png", $row->imageurl)) {
								?>
								<img src="../images/tinkerformss/<?php echo $row->imageurl; ?>" name="imagelib" />
								<?php
							} else {
								?>
								<img src="images/blank.png" name="imagelib" />
								<?php
							}
							?>
						</td>
					</tr>
					<tr>
						<td valign="top" class="key">
							<label for="tags">
								<?php echo JText::_( 'Tags' ); ?>:
							</label>
						</td>
						<td>
							<textarea class="inputbox" cols="70" rows="3" name="tags" id="tags"><?php echo $row->tags;?></textarea>
						</td>
					</tr>
				</tbody>
				</table>
			</fieldset>
		</div>
		<div class="clr"></div>

		<input type="hidden" name="c" value="tinkerforms" />
		<input type="hidden" name="option" value="com_tinkerforms" />
		<input type="hidden" name="bid" value="<?php echo $row->bid; ?>" />
		<input type="hidden" name="clicks" value="<?php echo $row->clicks; ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="impmade" value="<?php echo $row->impmade; ?>" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
		<?php
	}
}