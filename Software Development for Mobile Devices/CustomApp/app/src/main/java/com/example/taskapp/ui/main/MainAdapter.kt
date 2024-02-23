package com.example.taskapp.ui.main

import android.graphics.Paint
import android.view.*
import android.view.ContextMenu.ContextMenuInfo
import android.widget.ImageView
import android.widget.TextView
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import androidx.appcompat.content.res.AppCompatResources
import androidx.constraintlayout.widget.ConstraintLayout
import androidx.recyclerview.widget.DefaultItemAnimator
import androidx.recyclerview.widget.DiffUtil
import androidx.recyclerview.widget.ListAdapter
import androidx.recyclerview.widget.RecyclerView
import com.example.taskapp.R
import com.example.taskapp.data.data.Task
import com.example.taskapp.databinding.LayoutRowBinding
import com.example.taskapp.ui.read.ReadFragment
import com.example.taskapp.ui.utils.formatDate
import com.example.taskapp.ui.utils.getCheckIcon
import com.example.taskapp.ui.utils.getStarIcon


class MainAdapter(var updateItem: (Task) -> Unit): ListAdapter<Task, MainAdapter.ViewHolder>(
    COMPARATOR
)  {

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {

        return ViewHolder(
            LayoutRowBinding.inflate(
                LayoutInflater.from(parent.context),
                parent,
                false
            )
        )
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {
        holder.itemView.setOnLongClickListener(null)
        val item = getItem(position)
        holder.bind(item)
        holder.itemView.setOnClickListener {
            ReadFragment.newInstance(item).show((it.context as AppCompatActivity).supportFragmentManager, "Read")
        }
        holder.itemView.setOnLongClickListener {
            false
        }
        holder.checkIcon.setOnClickListener {
            item.status = when(item.status) {
                0 -> 1 else -> 0
            }
            holder.bindCheck(item)
            updateItem(item)
            if(item.status == 1)
                Toast.makeText(holder.itemView.context, "Task completed!", Toast.LENGTH_SHORT).show()
        }
        holder.starIcon.setOnClickListener {
            item.starred = !item.starred
            holder.bindStar(item)
            updateItem(item)
            if(item.starred)
                Toast.makeText(holder.itemView.context, "Task starred.", Toast.LENGTH_SHORT).show()
            else
                Toast.makeText(holder.itemView.context, "Star removed.", Toast.LENGTH_SHORT).show()
        }
        holder.onSelectComplete {
            item.status = 1
            holder.bindCheck(item)
            updateItem(item)
            Toast.makeText(holder.itemView.context, "Task completed!", Toast.LENGTH_SHORT).show()
        }
        holder.onSelectWontDo {
            item.status = 2
            holder.bindCheck(item)
            updateItem(item)
            Toast.makeText(holder.itemView.context, "Task marked as Won't do.", Toast.LENGTH_SHORT).show()
        }
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int, payloads: MutableList<Any>) {
        holder.itemView.setOnLongClickListener(null)
        if (payloads.isNotEmpty()) {
            val item: Task = getItem(position)
            for (payload in payloads) {
                when(payload) {
                    PAYLOAD_CHECK -> {
                        holder.bindCheck(item)
                    }
                    PAYLOAD_STAR -> {
                        holder.bindStar(item)
                    }
                    PAYLOAD_NAME -> {
                        holder.bindName(item)
                    }
                    PAYLOAD_DETAILS -> {
                        holder.bindDetails(item)
                    }
                }
            }
        } else {
            // in this case regular onBindViewHolder will be called
            super.onBindViewHolder(holder, position, payloads)
        }
    }

    override fun getItemViewType(position: Int): Int {
        val item = getItem(position)
        return if(item.due == null
            && item.estimate == null
            && item.plan == null
            && item.remind == null
            && item.description.isNullOrEmpty()) 0
        else 1
    }

    override fun onViewRecycled(holder: ViewHolder) {
        super.onViewRecycled(holder)
    }

    override fun getItemId(position: Int): Long {
        return getItem(position).id
    }

    inner class ViewHolder(binding: LayoutRowBinding) : RecyclerView.ViewHolder(binding.root),
        View.OnCreateContextMenuListener {

        val nameView: TextView = binding.nameView
        val checkIcon: ImageView = binding.checkIcon
        val starIcon: ImageView = binding.starIcon
        val detailView: TextView = binding.detailView

        init {
            checkIcon.setOnCreateContextMenuListener(this)
        }

        fun bindName(item: Task) {
            nameView.text = item.name
        }

        fun bindDetails(item: Task) {
            if(itemViewType == 1) {
                val datePattern = "EEE, MMM d"
                if(item.due != null) {
                    detailView.text = "Due: ${formatDate(item.due!!, datePattern)}"
                    detailView.setCompoundDrawablesRelativeWithIntrinsicBounds(
                        AppCompatResources.getDrawable(itemView.context, R.drawable.ic_due_14), null,null,null)
                }
                else if(item.estimate != null) {
                    detailView.text = if(item.estimate == 1) "Duration: 1 day" else "Duration: ${item.estimate} days"
                    detailView.setCompoundDrawablesRelativeWithIntrinsicBounds(
                        AppCompatResources.getDrawable(itemView.context, R.drawable.ic_estimate_14), null,null,null)
                }
                else if(item.plan != null) {
                    detailView.text = "Planned: " + formatDate(item.plan!!, datePattern)
                    detailView.setCompoundDrawablesRelativeWithIntrinsicBounds(
                        AppCompatResources.getDrawable(itemView.context, R.drawable.ic_plan_14), null,null,null)
                }
                else if(!item.description.isNullOrEmpty()) {
                    if(item.description!!.length < 30) {
                        detailView.text = "${item.description}"
                    }
                    else {
                        detailView.text = "${item.description!!.subSequence(0, 30)}..."
                    }
                    detailView.setCompoundDrawablesRelativeWithIntrinsicBounds(AppCompatResources.getDrawable(itemView.context, R.drawable.ic_description_14),null,null,null)
                }
                else if(item.remind != null) {
                    detailView.text = "Remind: " + formatDate(item.remind!!, datePattern)
                    detailView.setCompoundDrawablesRelativeWithIntrinsicBounds(
                        AppCompatResources.getDrawable(itemView.context, R.drawable.ic_remind_14), null,null,null)
                }
            }

            else if(itemViewType == 0) {
                // Remove detailView
                detailView.visibility = View.GONE
                val params =  nameView.layoutParams as ConstraintLayout.LayoutParams
                params.bottomToTop = ConstraintLayout.LayoutParams.UNSET
                params.bottomToBottom = ConstraintLayout.LayoutParams.PARENT_ID
            }
        }

        fun bindStar(item: Task) {
            starIcon.setImageDrawable(getStarIcon(item.starred, itemView.context))
        }

        fun bindCheck(item: Task) {
            checkIcon.setImageDrawable(getCheckIcon(item.status, itemView.context))
            if(item.status != 0) {
                nameView.paintFlags = Paint.STRIKE_THRU_TEXT_FLAG
            }
            else {
                nameView.paintFlags = nameView.paintFlags and Paint.STRIKE_THRU_TEXT_FLAG.inv()
            }
        }

        // bind data to row view
        fun bind(item: Task) {
            bindName(item)
            bindDetails(item)
            bindStar(item)
            bindCheck(item)
        }

        private lateinit var contextSelectComplete: () -> Unit

        fun onSelectComplete(lambda: () -> Unit) {
            contextSelectComplete = lambda
        }

        private lateinit var contextSelectWontDo: () -> Unit

        fun onSelectWontDo(lambda: () -> Unit) {
            contextSelectWontDo = lambda
        }

        override fun onCreateContextMenu(
            menu: ContextMenu, v: View,
            menuInfo: ContextMenuInfo?
        ) {

            menu.setHeaderTitle("Check task as...")

            menu.add(
                Menu.NONE, R.id.context_menu_completed,
                Menu.NONE, R.string.menu_completed
            ).setOnMenuItemClickListener {
                contextSelectComplete()
                true
            }

            menu.add(
                Menu.NONE, R.id.context_menu_wont_do,
                Menu.NONE, R.string.menu_wont_do
            ).setOnMenuItemClickListener {
                contextSelectWontDo()
                true
            }
        }
    }

    companion object {

        const val PAYLOAD_CHECK = "payload_check"
        const val PAYLOAD_STAR = "payload_star"
        const val PAYLOAD_NAME = "payload_name"
        const val PAYLOAD_DETAILS = "payload_details"

        private val COMPARATOR = object : DiffUtil.ItemCallback<Task>() {
            override fun areItemsTheSame(oldItem: Task, newItem: Task): Boolean {
                return oldItem.id == newItem.id
            }

            override fun areContentsTheSame(oldItem: Task, newItem: Task): Boolean {
                val x = oldItem == newItem
                return oldItem == newItem
            }

            override fun getChangePayload(oldItem: Task, newItem: Task): Any? {
                if(oldItem.status != newItem.status) {
                    return PAYLOAD_CHECK
                }
                if(oldItem.starred != newItem.starred) {
                    return PAYLOAD_STAR
                }
                if(oldItem.name != newItem.name) {
                    return PAYLOAD_NAME
                }
                if(oldItem.due != newItem.due
                    || oldItem.estimate != newItem.estimate
                    || oldItem.plan != newItem.plan
                    || oldItem.remind != newItem.remind
                    || oldItem.description != newItem.description) {
                    return PAYLOAD_DETAILS
                }
                return super.getChangePayload(oldItem, newItem)
            }
        }
    }
}