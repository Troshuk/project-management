import Pagination from "@/Components/Pagination";
import SelectInput from "@/Components/SelectInput";
import TextInput from "@/Components/TextInput";
import TableHeading from "@/Components/TableHeading";
import {TASK_STATUS_CLASS_MAP, TASK_STATUS_TEXT_MAP} from "@/constants.js";
import {Link, router} from "@inertiajs/react";

export default function TasksTable({
                                     tasks,
                                     success,
                                     queryParams = null,
                                     hideProjectColumn = false,
                                     currentRoute = route("task.index")
                                   }) {
  queryParams = queryParams || {};

  const filterFieldsConfig = {
    name: '$contains'
  };

  const searchFieldChanged = (name, value) => {
    if (value) {
      queryParams.filters = {
        ...queryParams.filters, [name]: {
          [getFilterOperator(name)]: value
        }
      }
    } else {
      delete queryParams.filters[name];
    }

    router.get(currentRoute, queryParams);
  };

  const getFilterOperator = name => filterFieldsConfig[name] ?? '$eq';

  const getFilterValue = (name) => {
    return queryParams?.filters?.[name]?.[getFilterOperator(name)] ?? '';
  }

  const onKeyPress = (name, e) => {
    if (e.key !== "Enter") {
      return;
    }

    searchFieldChanged(name, e.target.value);
  };

  const sortChanged = (name) => {
    if (`${name}:asc` === queryParams.sort) {
      queryParams.sort = `${name}:desc`;
    } else {
      queryParams.sort = `${name}:asc`;
    }

    router.get(route("task.index"), queryParams);
  };

  const deleteTask = (task) => {
    if (!window.confirm("Are you sure you want to delete the task?")) {
      return;
    }
    router.delete(route("task.destroy", task.id));
  };

  return (<>
    {success && (<div className="bg-emerald-500 py-2 px-4 text-white rounded mb-4">
      {success}
    </div>)}
    <div className="overflow-auto">
      <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead
          className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
        <tr className="text-nowrap">
          <TableHeading
            name="id"
            sort={queryParams.sort}
            sortChanged={sortChanged}
          >
            ID
          </TableHeading>
          <th className="px-3 py-3">Image</th>
          {!hideProjectColumn && (<th className="px-3 py-3">Project Name</th>)}
          <TableHeading
            name="name"
            sort={queryParams.sort}
            sortChanged={sortChanged}
          >
            Name
          </TableHeading>

          <TableHeading
            name="status"
            sort={queryParams.sort}
            sortChanged={sortChanged}
          >
            Status
          </TableHeading>

          <TableHeading
            name="created_at"
            sort={queryParams.sort}
            sortChanged={sortChanged}
          >
            Create Date
          </TableHeading>

          <TableHeading
            name="due_date"
            sort={queryParams.sort}
            sortChanged={sortChanged}
          >
            Due Date
          </TableHeading>
          <th className="px-3 py-3">Created By</th>
          <th className="px-3 py-3 text-right">Actions</th>
        </tr>
        </thead>
        <thead
          className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
        <tr className="text-nowrap">
          <th className="px-3 py-3"></th>
          <th className="px-3 py-3"></th>
          {!hideProjectColumn && <th className="px-3 py-3"></th>}
          <th className="px-3 py-3">
            <TextInput
              className="w-full"
              defaultValue={getFilterValue('name')}
              placeholder="Task Name"
              onBlur={(e) => searchFieldChanged("name", e.target.value)}
              onKeyPress={(e) => onKeyPress("name", e)}
            />
          </th>
          <th className="px-3 py-3">
            <SelectInput
              className="w-full"
              defaultValue={getFilterValue('status')}
              onChange={(e) => searchFieldChanged("status", e.target.value)}
            >
              <option value="">Select Status</option>
              <option value="pending">Pending</option>
              <option value="in_progress">In Progress</option>
              <option value="completed">Completed</option>
            </SelectInput>
          </th>
          <th className="px-3 py-3"></th>
          <th className="px-3 py-3"></th>
          <th className="px-3 py-3"></th>
          <th className="px-3 py-3"></th>
        </tr>
        </thead>
        <tbody>
        {tasks.data.map((task) => (<tr
          className="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
          key={task.id}
        >
          <td className="px-3 py-2">{task.id}</td>
          <td className="px-3 py-2">
            <img src={task.image} style={{width: 60}}/>
          </td>
          {!hideProjectColumn && (<td className="px-3 py-2">{task.project?.name}</td>)}
          <th className="px-3 py-2 text-gray-100 hover:underline">
            <Link href={route("task.show", task.id)}>{task.name}</Link>
          </th>
          <td className="px-3 py-2">
                  <span
                    className={"px-2 py-1 rounded text-nowrap text-white " + TASK_STATUS_CLASS_MAP[task.status]}
                  >
                    {TASK_STATUS_TEXT_MAP[task.status]}
                  </span>
          </td>
          <td className="px-3 py-2 text-nowrap">{task.created_at}</td>
          <td className="px-3 py-2 text-nowrap">{task.due_date}</td>
          <td className="px-3 py-2">{task.createdBy.name}</td>
          <td className="px-3 py-2 text-nowrap">
            <Link
              href={route("task.edit", task.id)}
              className="font-medium text-blue-600 dark:text-blue-500 hover:underline mx-1"
            >
              Edit
            </Link>
            <button
              onClick={(e) => deleteTask(task)}
              className="font-medium text-red-600 dark:text-red-500 hover:underline mx-1"
            >
              Delete
            </button>
          </td>
        </tr>))}
        </tbody>
      </table>
    </div>
    <Pagination links={tasks.meta.links}/>
  </>);
}
