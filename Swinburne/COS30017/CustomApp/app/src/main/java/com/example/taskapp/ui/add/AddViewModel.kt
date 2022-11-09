package com.example.taskapp.ui.add

import androidx.lifecycle.*
import com.example.taskapp.data.data.Task
import com.example.taskapp.data.repository.MyRepository
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.launch
import java.util.*

class AddViewModel (private val repository: MyRepository) : ViewModel() {

    private val mutableName = MutableLiveData("")
    val name: LiveData<String> get() = mutableName
    fun setName(name: String) {
        mutableName.value = name
    }

    private val mutableStatus = MutableLiveData(0)
    val status: LiveData<Int> get() = mutableStatus
    fun setStatus(status: Int) {
        mutableStatus.value = status
    }

    private val mutableStarred = MutableLiveData<Boolean>(false)
    val starred: LiveData<Boolean> get() = mutableStarred
    fun setStarred(starred: Boolean) {
        mutableStarred.value = starred
    }
    fun switchStarred() {
        if(mutableStarred.value == null) {
            mutableStarred.value = false
        }
        else {
            mutableStarred.value = !(mutableStarred.value)!!
        }
    }

    private val mutableDue = MutableLiveData<Date?>(null)
    val due: LiveData<Date?> get() = mutableDue
    fun setDue(due: Date?) {
        mutableDue.value = due
    }

    private val mutableEstimate = MutableLiveData<Int?>(null)
    val estimate: LiveData<Int?> get() = mutableEstimate
    fun setEstimate(estimate: Int?) {
        mutableEstimate.value = estimate
    }
    fun getEstimate(): Int? {
        return mutableEstimate.value
    }

    private val mutablePlan = MutableLiveData<Date?>(null)
    val plan: LiveData<Date?> get() = mutablePlan
    fun setPlan(plan: Date?) {
        mutablePlan.value = plan
    }

    private val mutableRemind = MutableLiveData<Date?>(null)
    val remind: LiveData<Date?> get() = mutableRemind
    fun setRemind(remind: Date?) {
        mutableRemind.value = remind
    }

    private val mutableDescription = MutableLiveData<String?>("")
    val description: LiveData<String?> get() = mutableDescription
    fun setDescription(description: String?) {
        mutableDescription.value = description
    }

    fun getTask() : Task {
        val name : String = if(mutableName.value.isNullOrEmpty()) "" else mutableName.value!!
        val status : Int = if(mutableStatus.value == null) 0 else mutableStatus.value!!
        val starred : Boolean = if(mutableStarred.value == null) false else mutableStarred.value!!
        return Task(
            name,
            status,
            starred,
            mutableDue.value,
            mutableEstimate.value,
            mutablePlan.value,
            mutableRemind.value,
            mutableDescription.value,
        )
    }

    fun setTask(task: Task) {
        setName(task.name)
        setStarred(task.starred)
        setStatus(task.status)
        setEstimate(task.estimate)
        setDue(task.due)
        setPlan(task.plan)
        setRemind(task.remind)
        setDescription(task.description)
    }

    fun reset() {
        setTask(Task())
    }

    fun insert(task: Task) {

        viewModelScope.launch(Dispatchers.IO) {
            task.createdTime = Calendar.getInstance().time
            task.modifiedTime = Calendar.getInstance().time
            repository.insert(task)
        }
    }
}

class AddViewModelFactory(private val repository: MyRepository) : ViewModelProvider.Factory {
    override fun <T : ViewModel> create(modelClass: Class<T>): T {
        if (modelClass.isAssignableFrom(AddViewModel::class.java)) {
            @Suppress("UNCHECKED_CAST")
            return AddViewModel(repository) as T
        }
        throw IllegalArgumentException("Unknown ViewModel class")
    }
}