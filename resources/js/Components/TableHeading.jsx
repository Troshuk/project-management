import {ChevronUpIcon, ChevronDownIcon} from "@heroicons/react/16/solid";

export default function TableHeading({
                                       name, sortable = true, sort = '', sortChanged = () => {
  }, children,
                                     }) {
  const sortArray = sort?.split(':');
  const sortFieldMatch = sortArray[0] === name;
  const sortDirection = sortArray[1];

  return (<th onClick={(e) => sortChanged(name)}>
    <div className="px-3 py-3 flex items-center justify-between gap-1 cursor-pointer">
      {children}
      {sortable && (<div>
        <ChevronUpIcon
          className={"w-4 " + (sortFieldMatch && sortDirection === "asc" ? "text-white" : "")}
        />
        <ChevronDownIcon
          className={"w-4 -mt-2 " + (sortFieldMatch && sortDirection === "desc" ? "text-white" : "")}
        />
      </div>)}
    </div>
  </th>);
}
