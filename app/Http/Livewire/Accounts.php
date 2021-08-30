<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Account;

class Accounts extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $name, $email, $cell_phone, $status, $type;
    public $updateMode = false;

    public function render()
    {
		$keyWord = '%'.$this->keyWord .'%';
        return view('livewire.accounts.view', [
            'accounts' => Account::latest()
						->orWhere('name', 'LIKE', $keyWord)
						->orWhere('email', 'LIKE', $keyWord)
						->orWhere('cell_phone', 'LIKE', $keyWord)
						->orWhere('status', 'LIKE', $keyWord)
						->orWhere('type', 'LIKE', $keyWord)
						->paginate(10),
        ]);
    }
	
    public function cancel()
    {
        $this->resetInput();
        $this->updateMode = false;
    }
	
    private function resetInput()
    {		
		$this->name = null;
		$this->email = null;
		$this->cell_phone = null;
		$this->status = null;
		$this->type = null;
    }

    public function store()
    {
        $this->validate([
		'name' => 'required',
		'status' => 'required',
		'type' => 'required',
        ]);

        Account::create([ 
			'name' => $this-> name,
			'email' => $this-> email,
			'cell_phone' => $this-> cell_phone,
			'status' => $this-> status,
			'type' => $this-> type
        ]);
        
        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Account Successfully created.');
    }

    public function edit($id)
    {
        $record = Account::findOrFail($id);

        $this->selected_id = $id; 
		$this->name = $record-> name;
		$this->email = $record-> email;
		$this->cell_phone = $record-> cell_phone;
		$this->status = $record-> status;
		$this->type = $record-> type;
		
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
		'name' => 'required',
		'status' => 'required',
		'type' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Account::find($this->selected_id);
            $record->update([ 
			'name' => $this-> name,
			'email' => $this-> email,
			'cell_phone' => $this-> cell_phone,
			'status' => $this-> status,
			'type' => $this-> type
            ]);

            $this->resetInput();
            $this->updateMode = false;
			session()->flash('message', 'Account Successfully updated.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Account::where('id', $id);
            $record->delete();
        }
    }
}
